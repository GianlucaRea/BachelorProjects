/**
 * @author GianlucaRea
 */
package com.company.pollweb.data.implementation;

import com.company.pollweb.data.models.Ruolo;

public class RuoloImpl implements Ruolo {
    protected int ruolo_id;
    protected String nome_ruolo;

    public RuoloImpl(){
        this.ruolo_id= 0 ;
        this.nome_ruolo= "";
    }

    public RuoloImpl(int ruolo_id, String nome_ruolo){
        this.ruolo_id = ruolo_id;
        this.nome_ruolo = nome_ruolo;
    }

    public int getRuolo_id(){
        return this.ruolo_id;
    }

    public void setRuolo_id(int newRuolo_id){
        this.ruolo_id = newRuolo_id;
    }

    public String getNome_ruolo() {
        return this.nome_ruolo;
    }

    public void setNome_ruolo(String newNome_ruolo){
        this.nome_ruolo = newNome_ruolo;
    }
}

