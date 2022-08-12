/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.company.pollweb.data.dao;

import com.company.pollweb.data.models.Utente;
import com.company.pollweb.framework.data.DataException;

import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ArrayList;

/**
 *
 * @author alessandrodorazio
 */
public interface UtenteDao {

    Utente getUtente(int id) throws DataException;

    Utente getUtenteByEmail(String email) throws DataException;

    Utente getUtentePerCompilazione(String email, String password, int sondaggio_id) throws DataException;

    Utente  creaUtente() throws DataException;

    Utente  creaUtente(ResultSet res) throws DataException;

    void  salvaUtente(Utente utente) throws DataException;

    void updatePassword(Utente utente) throws DataException;

    ArrayList<Utente> listaResponsabili() throws SQLException;

}
