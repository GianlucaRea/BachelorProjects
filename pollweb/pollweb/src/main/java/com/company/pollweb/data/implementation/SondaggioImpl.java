/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.company.pollweb.data.implementation;

import com.company.pollweb.data.models.Domanda;
import com.company.pollweb.data.models.Sondaggio;

/**
 *
 * @author gianlucarea
 */
public class SondaggioImpl implements Sondaggio {
    
    protected String  titolo, testoiniziale, testofinale;
    protected int id, utente_id, visibilita, stato;

    
    public SondaggioImpl(){
        this.id = -1;
    }
    
    public SondaggioImpl(String titolo, String testoiniziale, String testofinale, int utente_id, int visibilita, int stato){
        this.titolo = titolo;
        this.testoiniziale = testoiniziale;
        this.testofinale = testofinale;
        this.utente_id = utente_id;
        this.visibilita = visibilita;
        this.stato = stato;
    }

    public int getId(){return this.id;}

    public String getTestofinale(){
        return this.testofinale;
    }
    
    public String getTestoiniziale(){
        return this.testoiniziale;
    }
    
    public String getTitolo(){
        return this.titolo;
    }
    
    public int getUtenteId(){return this.utente_id;}

    public int getStato(){ return this.stato; }

    public String getNomeStato() {
        if(this.stato == 0 ) return "Non attivo";
        if(this.stato == 1) return "Attivo";
        return "Concluso";
    }

    public int getVisibilita(){return this.visibilita;}

    public String getNomeVisibilita() {
        return (this.visibilita==1)?"Pubblico":"Privato";
    }

    public Sondaggio getSondaggio(){return this;}


    public void setId(int id){this.id = id;} // NON DEVE ESSERE POSSIBILE IMPOSTARE L'ID DI UN SONDAGGIO
    
    public void setTestofinale(String testofinale){
         this.testofinale = testofinale;
    }
    
    public void setTestoiniziale(String testoiniziale){
         this.testoiniziale =  testoiniziale;
    }
    
    public void setTitolo(String titolo){
         this.titolo = titolo;
    }
    
    public void setUtenteId(int utente_id){
         this.utente_id = utente_id;
    }

    public void setVisibilita(int visibilita) { this.visibilita = visibilita; }

    public void setStato(int stato) { this.stato = stato; }
    
    
}
