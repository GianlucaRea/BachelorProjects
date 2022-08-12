package com.company.pollweb.data.dao;

import com.company.pollweb.data.models.Domanda;
import com.company.pollweb.data.proxy.DomandaProxy;
import com.company.pollweb.framework.data.DAO;
import com.company.pollweb.framework.data.DataException;
import com.company.pollweb.framework.data.DataLayer;
import org.json.JSONObject;

import java.sql.*;
import java.util.ArrayList;
import java.util.List;
import java.util.logging.Level;
import java.util.logging.Logger;

import static com.company.pollweb.utility.Serializer.StringToJSON;

public class DomandaDao_MySQL extends DAO implements DomandaDao {

    private PreparedStatement inserimento_domanda, domande_by_sondaggioID, domanda_by_id, domande_ids_by_sondaggoID;
    private PreparedStatement modifica_domanda, elimina_domanda, max_ordine, update_ordine, sondaggio_by_DID;

    public DomandaDao_MySQL(DataLayer d) {
        super(d);
    }

    public void init() throws DataException {

        try {
            super.init();
            inserimento_domanda = connection.prepareStatement("INSERT INTO Domanda (sondaggio_id, testo, nota, obbligo, tipologia, vincoli, ordine) VALUES (?, ?, ?, ?, ?, ?, ?);", Statement.RETURN_GENERATED_KEYS);
            domande_by_sondaggioID = connection.prepareStatement("SELECT * FROM Domanda WHERE sondaggio_id=? ORDER BY ordine ASC;");
            domanda_by_id = connection.prepareStatement("SELECT * FROM Domanda WHERE ID=?;");
            domande_ids_by_sondaggoID = connection.prepareStatement("SELECT id FROM Domanda WHERE sondaggio_id=?;");
            modifica_domanda = connection.prepareStatement("UPDATE Domanda SET testo=?,nota=?,obbligo=?,tipologia=?,vincoli=? WHERE id=?;");
            elimina_domanda = connection.prepareStatement("DELETE FROM Domanda WHERE id=?;");
            max_ordine = connection.prepareStatement("SELECT max(ordine) AS max_ordine FROM Domanda WHERE sondaggio_id = ?;");
            update_ordine = connection.prepareStatement("UPDATE Domanda SET ordine=? WHERE id=?;");
            sondaggio_by_DID = connection.prepareCall("SELECT sondaggio_id FROM Domanda WHERE id=?;");
        } catch (SQLException ex) {
            throw new DataException("Errore durante l'inizializzazione del data layer internship tutor", ex);
        }
    }

    public void destroy() throws DataException {
        try {
            inserimento_domanda.close();
            domande_by_sondaggioID.close();
            domanda_by_id.close();
            domande_ids_by_sondaggoID.close();
            modifica_domanda.close();
            elimina_domanda.close();
            max_ordine.close();
            update_ordine.close();
            sondaggio_by_DID.close();
        } catch (SQLException ex) {
            Logger.getLogger(SondaggioDao_MySQL.class.getName()).log(Level.SEVERE, null, ex);
        }
        super.destroy();
    }

    @Override
    public DomandaProxy creazioneDomanda() {
        return new DomandaProxy(getDataLayer());
    }

    @Override
    public DomandaProxy creazioneDomanda(ResultSet rs) throws DataException {
        try {
            DomandaProxy a = creazioneDomanda();
            if (rs.getInt("id") > 0) {
                a.setId(rs.getInt("id"));
            }
            a.setTesto(rs.getString("testo"));
            a.setNota(rs.getString("nota"));
            a.setObbligo(rs.getInt("obbligo"));
            a.setTipologia(rs.getString("tipologia"));
            a.setVincoli(StringToJSON(rs.getString("vincoli")));
            a.setOrdine(rs.getInt("ordine"));

            String type = a.getTipologia();
            switch (type) {
                case "testo_breve":
                    JSONObject tbJSON = a.getVincoli();
                    if (tbJSON.has("max_length")) {
                        a.setMax_length(tbJSON.getInt("max_length"));
                    }
                    if (tbJSON.has("pattern")) {
                        a.setPattern(tbJSON.getString("pattern"));
                    }
                    break;
                case "testo_lungo":
                    JSONObject tlJSON = a.getVincoli();
                    if (tlJSON.has("min_length")) {
                        a.setMin_length(tlJSON.getInt("min_length"));
                    }
                    if (tlJSON.has("max_length")) {
                        a.setMax_length(tlJSON.getInt("max_length"));
                    }
                    if (tlJSON.has("pattern")) {
                        System.out.println(tlJSON.get("pattern"));
                        a.setPattern(tlJSON.getString("pattern"));
                    }
                    break;
                case "numero":
                    JSONObject nJSON = a.getVincoli();
                    if (nJSON.has("min_num")) {
                        a.setMin_num(nJSON.getInt("min_num"));
                    }
                    if (nJSON.has("max_num")) {
                        a.setMax_num(nJSON.getInt("max_num"));
                    }
                    break;
                case "data":
                    JSONObject dJSON = a.getVincoli();
                    if (dJSON.has("date")) {
                        a.setDataSuccessivaOdierna(dJSON.getInt("date"));
                    }
                    break;
                case "scelta_singola":
                    JSONObject ssJSON = a.getVincoli();
                    a.setChooses(ssJSON.getJSONArray("chooses"));
                    break;
                case "scelta_multipla":
                    JSONObject smJSON = a.getVincoli();
                    a.setChooses(smJSON.getJSONArray("chooses"));
                    if (smJSON.has("min_chooses")) {
                        a.setMin_chooses(smJSON.getInt("min_chooses"));
                    }
                    if (smJSON.has("max_chooses")) {
                        a.setMax_chooses(smJSON.getInt("max_chooses"));
                    }
                    break;
            }

            return a;
        } catch (SQLException ex) {
            throw new DataException("Incapace di creare domanda dal ResultSet", ex);
        }
    }

    @Override
    public void salvaDomanda(Domanda d) throws DataException {
        int id = d.getId();
        try {
            if (d.getId() > 0) {
                if (d instanceof DomandaProxy && ((DomandaProxy) d).isDirty()) {
                    return;
                }
                modifica_domanda.setString(1, d.getTesto());
                modifica_domanda.setString(2, d.getNota());
                modifica_domanda.setInt(3, d.getObbligo());
                modifica_domanda.setString(4, d.getTipologia());
                String stringToBeInserted = JSONObject.valueToString(d.getVincoli());
                modifica_domanda.setString(5, stringToBeInserted);
                modifica_domanda.setInt(6, d.getId());
                modifica_domanda.executeUpdate();
            } else {
                inserimento_domanda.setInt(1, d.getSondaggio_id());
                inserimento_domanda.setString(2, d.getTesto());
                inserimento_domanda.setString(3, d.getNota());
                inserimento_domanda.setInt(4, d.getObbligo());
                inserimento_domanda.setString(5, d.getTipologia());
                String stringToBeInserted = JSONObject.valueToString(d.getVincoli());
                inserimento_domanda.setString(6, stringToBeInserted);
                inserimento_domanda.setInt(7, d.getOrdine());
                if (inserimento_domanda.executeUpdate() == 1) {
                    try (ResultSet rs = inserimento_domanda.getGeneratedKeys()) {
                        if (rs.next()) {
                            id = rs.getInt(1);
                        }
                    }
                    d.setId(id);
                }
            }
        } catch (SQLException ex) {
            ex.printStackTrace();
            throw new DataException("Impossibile inserire o modificare la Domanda", ex);
        }

    }

    @Override
    public List<Domanda> getDomandeBySondaggioID(int sondaggioId) throws DataException {
        List<Domanda> domande = new ArrayList();
        try {
            domande_by_sondaggioID.setInt(1, sondaggioId);
            try (ResultSet rs = domande_by_sondaggioID.executeQuery()) {
                while (rs.next()) {
                    domande.add((Domanda) getDomandaByID(rs.getInt("id")));
                }
            }
        } catch (SQLException ex) {
            throw new DataException("Impossibile caricare le Domande By Sondaggio", ex);
        }
        return domande;
    }

    @Override
    public List<Integer> getDomandeIdsBySondaggioID(int sondaggioId) throws DataException {
        List<Integer> list = new ArrayList();
        try {
            domande_ids_by_sondaggoID.setInt(1, sondaggioId);
            try (ResultSet rs = domande_ids_by_sondaggoID.executeQuery()) {
                while (rs.next()) {
                    list.add(rs.getInt("id"));
                }
            }
        } catch (SQLException ex) {
            throw new DataException("Impossibile caricare gli id delle Domande by Sondaggio", ex);
        }
        return list;
    }

    @Override
    public void eliminaDomanda(int domanda_id) throws DataException {
        try {
            elimina_domanda.setInt(1, domanda_id);
            elimina_domanda.execute();
        } catch (SQLException ex) {
            throw new DataException("Impossibile eliminare Domande By ID", ex);
        }
    }

    @Override
    public int prendiOrdine(int sondaggio_id) throws DataException {
        try {
            int i = 1;
            max_ordine.setInt(1, sondaggio_id);
            try (ResultSet rs = max_ordine.executeQuery()) {
                if (rs.next()) {
                    i = rs.getInt("max_ordine");
                    return i + 1;
                } else {
                    return i;
                }
            }
        } catch (SQLException ex) {
            throw new DataException("Impossibile prende il massimo ordine in Domande By SondaggioID", ex);
        }
    }

    @Override
    public void UpdateOrdine(int domandaid, int newOrdine) throws DataException {
        try {
            update_ordine.setInt(1, newOrdine);
            update_ordine.setInt(2, domandaid);
            update_ordine.executeUpdate();
        } catch (SQLException ex) {
            throw new DataException("Impossibile effettuare lo scambio", ex);
        }
    }


    @Override
    public Domanda getDomandaByID(int domanda_id) throws DataException {
        try {
            domanda_by_id.setInt(1, domanda_id);
            try (ResultSet rs = domanda_by_id.executeQuery()) {
                if (rs.next()) {
                    return creazioneDomanda(rs);
                }
            }
        } catch (SQLException ex) {
            throw new DataException("Impossibile caricare Domande By ID", ex);
        }
        return null;
    }

    public int getSID(int domanda_id) throws DataException {
        try {
            sondaggio_by_DID.setInt(1, domanda_id);
            try(ResultSet rs = sondaggio_by_DID.executeQuery()){
                if(rs.next()){
                  return rs.getInt("sondaggio_id");
                }
            }
        } catch (SQLException ex) {
            throw new DataException("Impossibile caricare Domande By ID", ex);
        }
        return 0;
    }
}
