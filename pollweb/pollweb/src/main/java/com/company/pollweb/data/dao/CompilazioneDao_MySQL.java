package com.company.pollweb.data.dao;

import com.company.pollweb.data.implementation.CompilazioneImpl;
import com.company.pollweb.data.implementation.UtenteImpl;
import com.company.pollweb.data.models.Compilazione;
import com.company.pollweb.data.models.Utente;
import com.company.pollweb.data.proxy.CompilazioneProxy;
import com.company.pollweb.framework.data.DAO;
import com.company.pollweb.framework.data.DataException;
import com.company.pollweb.framework.data.DataLayer;
import com.company.pollweb.utility.Pair;
import org.json.JSONArray;
import org.json.JSONObject;

import java.sql.*;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;
import java.util.concurrent.atomic.AtomicInteger;
import java.util.logging.Level;
import java.util.logging.Logger;

public class CompilazioneDao_MySQL extends DAO implements CompilazioneDao {

    private PreparedStatement inserimento_compilazione , getUserList , get_risposte , get_compilazione_id , get_risposte_bySondaggioAndUtente ,get_compilazione , getUserListIds, getCompilazioneIds ,getRisposteByCompilazioneId;

    public CompilazioneDao_MySQL(DataLayer d) {
        super(d);
    }

    public void init() throws DataException {

        try {
            super.init();
            inserimento_compilazione = connection.prepareStatement("INSERT INTO Compilazione (sondaggio_id) VALUES (?);", Statement.RETURN_GENERATED_KEYS);
            getUserList = connection.prepareStatement("SELECT * FROM Compilazione c, Utente u WHERE c.sondaggio_id=? AND c.utente_id = u.id;");
            get_risposte = connection.prepareStatement("SELECT risposta FROM CompilazioneDomanda WHERE domanda_id=?;");
            get_compilazione_id = connection.prepareStatement("SELECT risposta,utente_id FROM Compilazione JOIN CompilazioneDomanda ON Compilazione.id = CompilazioneDomanda.compilazione_id WHERE domanda_id = ?;");
            get_risposte_bySondaggioAndUtente = connection.prepareStatement("SELECT risposta FROM Compilazione JOIN CompilazioneDomanda ON Compilazione.id = CompilazioneDomanda.compilazione_id WHERE sondaggio_id = ? AND utente_id = ?;");
            get_compilazione = connection.prepareStatement("SELECT * FROM Compilazione WHERE sondaggio_id=? AND utente_id=?;");
            getUserListIds = connection.prepareStatement("SELECT utente_id FROM Compilazione WHERE sondaggio_id = ?;");
            getCompilazioneIds = connection.prepareStatement("SELECT id, utente_id FROM Compilazione WHERE sondaggio_id = ?;");
            getRisposteByCompilazioneId = connection.prepareStatement("SELECT cd.domanda_id, cd.risposta FROM CompilazioneDomanda cd, Domanda d WHERE cd.compilazione_id=? AND cd.domanda_id=d.id ORDER BY d.ordine ASC;");
        } catch (SQLException ex) {
            throw new DataException("Errore durante l'inizializzazione del data layer", ex);
        }
    }

    public void destroy() throws DataException {
        try {
            inserimento_compilazione.close();
            getUserList.close();
            get_risposte.close();
            get_compilazione_id.close();
            get_risposte_bySondaggioAndUtente.close();
            get_compilazione.close();
            getUserListIds.close();
            getCompilazioneIds.close();
        } catch (SQLException ex) {
            Logger.getLogger(SondaggioDao_MySQL.class.getName()).log(Level.SEVERE, null, ex);
        }
        super.destroy();
    }

    @Override
    public CompilazioneProxy creazioneCompilazione() {
        return new CompilazioneProxy(getDataLayer());
    }

    @Override
    public CompilazioneProxy creazioneCompilazione(ResultSet rs) throws DataException {
        try {
            CompilazioneProxy a = creazioneCompilazione();
            if(rs.getInt("id") > 0 ) {
                a.setId(rs.getInt("id"));
            }
            a.setSondaggioId(rs.getInt("sondaggio_id"));
            a.setUserId(rs.getInt("utente_id"));
            return a;
        } catch (SQLException ex) {
            throw new DataException("Incapace di creare domanda dal ResultSet", ex);
        }
    }

    @Override
    public void salvaCompilazione(Compilazione c) throws DataException {
        int id = c.getId();
        try  {
            if (c.getId() > 0) {
                if (c instanceof CompilazioneProxy && ((CompilazioneProxy) c).isDirty()) {
                    return;
                }
            } else {
                inserimento_compilazione.setInt(1, c.getSondaggioId());
                if (inserimento_compilazione.executeUpdate() == 1) {
                    try (ResultSet rs = inserimento_compilazione.getGeneratedKeys()) {
                        if (rs.next()) {
                            id = rs.getInt(1);
                        }
                    }
                    c.setId(id);
                }
                inserimento_compilazione.close();
            }
            inserimento_compilazione.close();
            this.destroy();
        } catch (SQLException ex) {
            ex.printStackTrace();
            throw new DataException("Impossibile inserire o modificare la compilazione", ex);
        }

    }

    public void salvaCompilazione(int compilazioneId, Map<Integer, JSONArray> risposte) throws SQLException {
        System.out.println("ENTRO");
        String inserisciRispostaSQL = "INSERT INTO CompilazioneDomanda(compilazione_id, domanda_id, risposta) VALUES ";
        for(int i=0; i <risposte.size(); i++) {
            inserisciRispostaSQL = inserisciRispostaSQL + "(?,?,?),";

        }

        inserisciRispostaSQL = inserisciRispostaSQL.substring(0, inserisciRispostaSQL.length()-1);
        inserisciRispostaSQL = inserisciRispostaSQL + ";";

        PreparedStatement inserisciRispostaQuery = connection.prepareStatement(inserisciRispostaSQL);
        AtomicInteger j= new AtomicInteger();
        risposte.forEach((domandaId, risposta) -> {
            try {
                String r = risposta.toString().substring(2);
                r = r.substring(0, r.toString().length()-2);
                System.out.println(r);
                inserisciRispostaQuery.setInt((3* j.get())+1, compilazioneId);
                inserisciRispostaQuery.setInt((3* j.get())+2, domandaId);
                inserisciRispostaQuery.setObject((3* j.get())+3, JSONObject.stringToValue(risposta.toString()));
            } catch (SQLException throwables) {
                throwables.printStackTrace();
            }
            j.set(j.get() + 1);
        });

        inserisciRispostaQuery.execute();

    }

    public Compilazione getCompilazione(int sondaggioId, int utenteid) throws SQLException {
        CompilazioneProxy c = creazioneCompilazione();
        get_compilazione.setInt(1, sondaggioId);
        get_compilazione.setInt(2, utenteid);
        try (ResultSet rs = get_compilazione.executeQuery()) {
            if (rs.next()) {
                return creazioneCompilazione(rs);
            }
        } catch (DataException e) {
            e.printStackTrace();
        }
        return c;
    }

    @Override
    public List<Utente> getUserList(int sondaggioId) throws DataException {
        List<Utente> list = new ArrayList();
         try {
             getUserList.setInt(1, sondaggioId);
             try(ResultSet rs = getUserList.executeQuery()){
                 while(rs.next()) {
                     Utente u = new UtenteImpl();
                     u.setNome(rs.getString("nome"));
                     u.setEmail(rs.getString("email"));
                     u.setPassword(rs.getString("password"));
                     list.add(u);
                 }
             }
         }catch (SQLException ex){
             throw new DataException("Impossibile caricare la lista di utente", ex);
         }
         return list;
    }

    @Override
    public List<String> getRisposteByDomandaId(int domandaId) throws DataException {
        List<String> list = new ArrayList();
        try {
            get_risposte.setInt(1, domandaId);
            try(ResultSet rs = get_risposte.executeQuery()){
                while(rs.next()) {
                    list.add(rs.getString("risposta"));
                }
            }
        }catch (SQLException ex){
            throw new DataException("Impossibile caricare la lista delle risposte dal id della domanda", ex);
        }
        return list;
    }

    public ArrayList<Pair>  getEmailByDomandaId(int domandaId) throws DataException {
        ArrayList<Pair> list = new ArrayList<Pair>();
        try {
            get_compilazione_id.setInt(1, domandaId);
            try(ResultSet rs = get_compilazione_id.executeQuery()){
                int i = 0;
                while(rs.next()) {
                    int a = rs.getInt("utente_id");
                    String b = rs.getString("risposta");
                    list.add(i , new Pair(a,b));
                    i++;
                }
            }
        }catch (SQLException ex){
            throw new DataException("Impossibile caricare la lista delle risposte alla domanda", ex);
        }
        return list;
    }

    public List<String> getRisposteBySondaggioAndUtente(int sondaggioid , int utenteid) throws DataException {
        List<String> list = new ArrayList();
        try{
            get_risposte_bySondaggioAndUtente.setInt(1,sondaggioid);
            get_risposte_bySondaggioAndUtente.setInt(2,utenteid);
            try(ResultSet rs = get_risposte_bySondaggioAndUtente.executeQuery()){
                while(rs.next()){
                    list.add(JSONObject.valueToString(rs.getObject("risposta")));
                }
                return list;
            }
        }catch(SQLException ex){
            throw new DataException("Impossibile caricare la lista delle risposte dall'email di colui che ha compilato", ex);
        }
    }

    public List<Integer> getUserListIds(int sondaggioId) throws DataException {
        List<Integer> list = new ArrayList();
        try {
            getUserListIds.setInt(1, sondaggioId);
            try(ResultSet rs = getUserListIds.executeQuery()){
                while(rs.next()) {
                    list.add(rs.getInt("utente_id"));
                }
            }
        }catch (SQLException ex){
            throw new DataException("Impossibile caricare la lista di id", ex);
        }
        return list;
    }

    @Override
    public Map<Integer, String> getRisposteByCompilazioneId(int compilazioneId) throws DataException {
        Map<Integer, String> list = new HashMap<>();
        try{
            getRisposteByCompilazioneId.setInt(1,compilazioneId);

            try(ResultSet rs = getRisposteByCompilazioneId.executeQuery()){
                while(rs.next()){
                    JSONArray risposta = new JSONArray(rs.getString("risposta"));

                    String rispostaVal = "";
                    if(risposta.length() > 1) {
                        for(int i = 0; i < risposta.length(); i++) {
                            rispostaVal = rispostaVal + risposta.get(i).toString() + ", ";
                        }
                        rispostaVal = rispostaVal.substring(0, rispostaVal.length() - 2);
                    } else {
                        rispostaVal = risposta.get(0).toString();
                    }
                    list.put(rs.getInt("domanda_id"), rispostaVal);
                }
                return list;
            }
        }catch(SQLException ex){
            throw new DataException("Impossibile caricare la lista delle risposte dalla compilazioneId", ex);
        }
    }


    @Override
    public List<Compilazione> getCompilazioneListIds(int sondaggioId) throws DataException {
        List<Compilazione> list = new ArrayList<Compilazione>();
        try {
            getCompilazioneIds.setInt(1, sondaggioId);
            try(ResultSet rs = getCompilazioneIds.executeQuery()){
                Compilazione c;
                while(rs.next()) {
                    c = new CompilazioneImpl();
                    System.out.println(rs.getInt("id"));
                    c.setId(rs.getInt("id"));
                    c.setUserId(rs.getInt("utente_id"));
                    list.add(c);
                }
            }
        }catch (SQLException ex){
            throw new DataException("Impossibile caricare la lista delle compilazioni", ex);
        }
        return list;
    }
}
