package com.company.pollweb.data.implementation;

import com.company.pollweb.data.models.Compilazione;
import com.company.pollweb.data.models.Domanda;

import java.util.ArrayList;

public class CompilazioneImpl implements Compilazione {

    protected int id, id_sondaggio ,id_utente;

    public CompilazioneImpl(){

    }

    public CompilazioneImpl(int id_sondaggio, int id_utente){
        this.id_sondaggio = id_sondaggio;
        this.id_utente = id_utente;
    }

    @Override
    public void setUserId(int id_utente) {this.id_utente = id_utente;}

    @Override
    public int getUserId() {return this.id_utente;}

    public void setId(int id) {this.id = id;}

    public int getId() { return id; }

    public int getSondaggioId() { return id_sondaggio; }

    public void setSondaggioId(int sondaggioId) { this.id_sondaggio = sondaggioId; }

}
