/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.company.pollweb.data.implementation;

import com.company.pollweb.data.models.Utente;

/**
 *
 * @author alessandrodorazio
 */
public class UtenteImpl implements Utente {
    protected String nome, cognome, email,password;
    protected int id, ruolo_id;

    public UtenteImpl() {

    }
    
    public UtenteImpl(String nome, String cognome, String email,int id, int ruolo_id) {
        this.id = id;
        this.nome = nome;
        this.cognome = cognome;
        this.email = email;
        this.ruolo_id = ruolo_id;
    }
    
    public String getNome() {
        return this.nome;
    }
    
    public String getCognome() {
        return this.cognome;
    }
    
    public String getNomeCompleto() {
        return this.nome + " " + this.cognome;
    }

    @Override
    public String getPassword() { return this.password; }

    public String getEmail() {
        return this.email;
    }
    
    public int getRuolo() {
        return this.ruolo_id;
    }

    public int getId() {return this.id;}

    public String getNomeRuolo() {
        if(this.ruolo_id == 3) return "Amministratore";
        if(this.ruolo_id == 2) return "Responsabile";
        return "Utente";
    }

    @Override
    public void setNome(String newNome) {
        this.nome = newNome;
    }

    @Override
    public void setCognome(String newCognome) {
        this.cognome = newCognome;
    }

    @Override
    public void setEmail(String newEmail) {
        this.email = newEmail;
    }

    @Override
    public void setPassword(String newPassword) {
        this.password = newPassword;
    }

    @Override
    public void setRuolo(int newRuoloId) {
        this.ruolo_id = newRuoloId;
    }

    public void setId(int newId) {this.id = newId;}
}
