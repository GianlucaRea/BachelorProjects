/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.company.pollweb.data.dao;

import com.company.pollweb.data.models.Domanda;
import com.company.pollweb.data.proxy.DomandaProxy;
import com.company.pollweb.framework.data.DataException;

import javax.xml.crypto.Data;
import java.sql.ResultSet;
import java.util.List;

/**
 *
 * @author gianlucarea
 */
public interface DomandaDao {

  DomandaProxy creazioneDomanda(ResultSet rs) throws DataException;

  DomandaProxy creazioneDomanda();

  void salvaDomanda(Domanda d) throws DataException;

  Domanda getDomandaByID(int domanda_id) throws DataException;

  List<Domanda> getDomandeBySondaggioID(int sondaggioId) throws DataException;

  List<Integer> getDomandeIdsBySondaggioID(int sondaggioId) throws DataException;

  void eliminaDomanda(int domanda_id) throws DataException;

  int prendiOrdine(int sondaggio_id) throws DataException;

  void UpdateOrdine(int domandaid , int newOrdine) throws DataException;

  int getSID(int domanda_id) throws DataException;
}
