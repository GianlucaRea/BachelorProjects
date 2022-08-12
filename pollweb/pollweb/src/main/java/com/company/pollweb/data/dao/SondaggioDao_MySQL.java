package com.company.pollweb.data.dao;

import com.company.pollweb.data.implementation.DomandaImpl;
import com.company.pollweb.data.implementation.SondaggioImpl;
import com.company.pollweb.data.models.Domanda;
import com.company.pollweb.data.models.Sondaggio;
import com.company.pollweb.data.models.Utente;
import com.company.pollweb.framework.data.DAO;
import com.company.pollweb.framework.data.DataException;
import com.company.pollweb.framework.data.DataLayer;
import com.company.pollweb.data.proxy.SondaggioProxy;

import java.sql.*;
import java.util.ArrayList;
import java.util.List;
import java.util.logging.Level;
import java.util.logging.Logger;

public class SondaggioDao_MySQL extends DAO implements SondaggioDao {


    private PreparedStatement inserimento_sondaggio , modifica_sondaggio;

    public SondaggioDao_MySQL(DataLayer d) {
        super(d);
    }

    @Override
    public void init() throws DataException {

        try {
            super.init();

            inserimento_sondaggio = connection.prepareStatement("INSERT INTO Sondaggio (utente_id, titolo, testoiniziale, testofinale, created_at) VALUES (?, ?, ?, ?, CURRENT_TIMESTAMP);",Statement.RETURN_GENERATED_KEYS);
            modifica_sondaggio = connection.prepareStatement("UPDATE Sondaggio SET utente_id=?,titolo=?,testoiniziale=?,testofinale=? WHERE id=?;");

        } catch (SQLException ex) {
            throw new DataException("Errore durante l'inizializzazione del data layer internship tutor", ex);
        }
    }

    @Override
    public void destroy() throws DataException {

        try {
            inserimento_sondaggio.close();
            modifica_sondaggio.close();
        } catch (SQLException ex) {
            Logger.getLogger(SondaggioDao_MySQL.class.getName()).log(Level.SEVERE, null, ex);
        }
        super.destroy();
    }

    @Override
    public SondaggioProxy creazioneSondaggio() {
        return new SondaggioProxy(getDataLayer());
    }


    @Override
    public SondaggioProxy creazioneSondaggio(ResultSet rs) throws DataException {
        try {
            SondaggioProxy a = creazioneSondaggio();
            a.setTitolo(rs.getString("titolo"));
            a.setTestoiniziale(rs.getString("testoiniziale"));
            a.setTestofinale(rs.getString("testofinale"));
            a.setUtenteId(rs.getInt("utente_id"));
            return a;
        } catch (SQLException ex) {
            throw new DataException("Unable to create Poll object from ResultSet", ex);
        }
    }


    public void salvaSondaggio(Sondaggio p) throws DataException {
        int id = p.getId();
        try {
            if (p.getId() > 0) {
                if (p instanceof SondaggioProxy && ((SondaggioProxy) p).isDirty()) {
                    return;
                }
                modifica_sondaggio.setInt(1, p.getUtenteId());
                modifica_sondaggio.setString(2, p.getTitolo());
                modifica_sondaggio.setString(3, p.getTestoiniziale());
                modifica_sondaggio.setString(4, p.getTestofinale());
                modifica_sondaggio.setInt(5,p.getId());
                modifica_sondaggio.executeUpdate();
            } else {
                inserimento_sondaggio.setInt(1, p.getUtenteId());
                inserimento_sondaggio.setString(2, p.getTitolo());
                inserimento_sondaggio.setString(3, p.getTestoiniziale());
                inserimento_sondaggio.setString(4, p.getTestofinale());
                if (inserimento_sondaggio.executeUpdate() == 1) {
                    try (ResultSet rs = inserimento_sondaggio.getGeneratedKeys()) {
                        if (rs.next()) {
                            id = rs.getInt(1);
                        }
                    }
                    p.setId(id);
                }
            }
        } catch (SQLException ex) {
            ex.printStackTrace();
            throw new DataException("Unable to insert or update Poll", ex);
        }
    }

    public Sondaggio getSondaggio(int sondaggioId) throws SQLException {
        PreparedStatement sondaggioQuery = connection.prepareStatement("SELECT * FROM Sondaggio WHERE id=?");
        sondaggioQuery.setInt(1, sondaggioId);
        ResultSet rs = sondaggioQuery.executeQuery();
        SondaggioImpl sondaggio = new SondaggioImpl();
        while(rs.next()) {
            sondaggio.setId(rs.getInt("id"));
            sondaggio.setUtenteId(rs.getInt("utente_id"));
            sondaggio.setTitolo(rs.getString("titolo"));
            sondaggio.setTestoiniziale(rs.getString("testoiniziale"));
            sondaggio.setTestofinale(rs.getString("testofinale"));
            sondaggio.setVisibilita(rs.getInt("visibilita"));
            sondaggio.setStato(rs.getInt("stato"));
        }
        rs.close();
        sondaggioQuery.close();
        return sondaggio;

    }

    public boolean isUtenteAbilitatoAllaCompilazione(Sondaggio sondaggio, int utente_id) throws SQLException {
        if(sondaggio.getVisibilita() == 1) {
            return true;
        } else {
            PreparedStatement emailCompilazioneQuery = connection.prepareStatement("SELECT COUNT(*) AS rowcount FROM Compilazione c, Utente u WHERE c.sondaggio_id=? AND c.utente_id=u.id AND u.id=?");
            emailCompilazioneQuery.setInt(1, sondaggio.getId());
            emailCompilazioneQuery.setInt(2, utente_id);
            ResultSet rs = emailCompilazioneQuery.executeQuery();
            rs.next();
            return rs.getInt("rowcount")==1;
        }
    }

    public ArrayList<Domanda> getDomande(int sondaggioId) throws SQLException {

        PreparedStatement getDomandeQuery = connection.prepareStatement("SELECT * FROM Domanda WHERE sondaggio_id=? ORDER BY ordine ASC");
        getDomandeQuery.setInt(1, sondaggioId);
        ResultSet rs = getDomandeQuery.executeQuery();

        ResultSetMetaData rsmd = rs.getMetaData();
        int countDomande = rsmd.getColumnCount();

        ArrayList<Domanda> domande = new ArrayList<Domanda>();

        Domanda d;
        while(rs.next()) {
            d = new DomandaImpl();
            d.setId(rs.getInt("id"));
            d.setSondaggio_id(rs.getInt("sondaggio_id"));
            d.setTesto(rs.getString("testo"));
            d.setNota(rs.getString("nota"));
            d.setObbligo(rs.getInt("obbligo"));
            d.setOrdine(rs.getInt("ordine"));
            d.setTipologia(rs.getString("tipologia"));
            domande.add(d);
        }
        rs.close();
        getDomandeQuery.close();
        return domande;
    }

    private ArrayList<Sondaggio> getSondaggi(PreparedStatement getListaSondaggiQuery) throws SQLException {
        ResultSet rs = getListaSondaggiQuery.executeQuery();

        ArrayList<Sondaggio> sondaggi = new ArrayList<Sondaggio>();
        Sondaggio s;
        while(rs.next()) {
            s = new SondaggioImpl();
            s.setId(rs.getInt("id"));
            s.setUtenteId(rs.getInt("utente_id"));
            s.setTitolo(rs.getString("titolo"));
            s.setTestoiniziale(rs.getString("testoiniziale"));
            s.setTestofinale(rs.getString("testofinale"));
            s.setStato(rs.getInt("stato"));
            s.setVisibilita(rs.getInt("visibilita"));
            sondaggi.add(s);
        }

        return sondaggi;
    }

    public ArrayList<Sondaggio> listaSondaggi() throws SQLException {
        PreparedStatement getListaSondaggiQuery = connection.prepareStatement("SELECT * FROM Sondaggio ORDER BY stato ASC, id DESC");
        return getSondaggi(getListaSondaggiQuery);
    }

    public ArrayList<Sondaggio> listaSondaggiResponsabile(int utenteId) throws SQLException {
        PreparedStatement getListaSondaggiQuery = connection.prepareStatement("SELECT * FROM Sondaggio WHERE utente_id=? ORDER BY stato ASC, id DESC");
        getListaSondaggiQuery.setInt(1, utenteId);
        return getSondaggi(getListaSondaggiQuery);
    }

    public boolean pubblicaSondaggio(int sondaggioId) throws SQLException {
        PreparedStatement pubblicaSondaggioQuery = connection.prepareStatement("UPDATE Sondaggio SET stato=1 WHERE id=?");
        pubblicaSondaggioQuery.setInt(1, sondaggioId);
        if(pubblicaSondaggioQuery.executeUpdate() == 1){
            return true;
        } else {
            return false;
        }
    }

    public boolean chiudiSondaggio(int sondaggioId) throws SQLException {
        PreparedStatement pubblicaSondaggioQuery = connection.prepareStatement("UPDATE Sondaggio SET stato=2 WHERE id=?");
        pubblicaSondaggioQuery.setInt(1, sondaggioId);
        return pubblicaSondaggioQuery.executeUpdate() == 1;
    }

    public boolean invitaUtenti(int sondaggioId, List<Utente> utenti) throws SQLException {
        String aggiungiUtentiSQL = "INSERT INTO Compilazione (sondaggio_id, utente_id) VALUES ";
        boolean execute = false;
        for(Utente utente: utenti) {
            if(utente.getEmail().length() > 0) {
                aggiungiUtentiSQL = aggiungiUtentiSQL + "(?, ?),";
            }
        }
        aggiungiUtentiSQL = aggiungiUtentiSQL.substring(0, aggiungiUtentiSQL.length()-1);
        aggiungiUtentiSQL = aggiungiUtentiSQL + ";";
        PreparedStatement aggiungiUtentiQuery = connection.prepareStatement(aggiungiUtentiSQL);
        System.out.println(aggiungiUtentiSQL);
        for(int i=0;i< utenti.size(); i++) {
            System.out.println(utenti.get(i));
            if(utenti.get(i).getEmail().length() > 0){
                aggiungiUtentiQuery.setInt((2*i)+1, sondaggioId);
                aggiungiUtentiQuery.setInt((2*i)+2, utenti.get(i).getId());
                execute = true;
            }
        }
        System.out.println(aggiungiUtentiSQL);
        if(execute) {
            aggiungiUtentiQuery.execute();
        }
        aggiungiUtentiQuery.close();
        return true;
    }

    public int modificaVisibilita(int sondaggioId, int nuovoValore) throws SQLException {
        System.out.println("ENTRO");
        String modificaVisibilitaSQL = "UPDATE Sondaggio SET visibilita=? WHERE id=?";
        System.out.println(modificaVisibilitaSQL);
        PreparedStatement modificaVisibilitaQuery = connection.prepareStatement(modificaVisibilitaSQL);
        modificaVisibilitaQuery.setInt(1, nuovoValore);
        modificaVisibilitaQuery.setInt(2, sondaggioId);
        modificaVisibilitaQuery.execute();
        return 1;
    }
}
