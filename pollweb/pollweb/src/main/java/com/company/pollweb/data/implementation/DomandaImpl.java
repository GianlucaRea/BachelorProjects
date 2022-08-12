/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.company.pollweb.data.implementation;

import com.company.pollweb.data.models.Domanda;
import org.json.JSONArray;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.List;

/**
 *
 * @author gianlucarea
 */
public class DomandaImpl implements Domanda {
    protected String nota, testo, tipologia;
    protected int id ,sondaggio_id  , obbligo , ordine;
    protected JSONObject vincoli;

    //vincoli per deserializzazione
    protected int min_length;
    protected int max_length;
    protected int min_num;
    protected int max_num;
    protected int dataSuccessivaOdierna;
    protected int min_chooses;
    protected int max_chooses;
    protected String pattern;
    protected JSONArray chooses;
   
    //manca vincoli che è in json

    public DomandaImpl(){
       this.nota = "";
       this.testo = "";
       this.obbligo = 0;
       this.ordine = 0;
    }
    
    public DomandaImpl(String nota, String testo, int sondaggio_id, String tipologia , JSONObject vincoli, int obbligo , int ordine ){
        this.nota = nota;
        this.testo = testo;
        this.sondaggio_id = sondaggio_id;
        this.tipologia = tipologia;
        this.obbligo = obbligo;
        this.ordine = ordine;
        this.vincoli = vincoli;
    }

    @Override
    public int getId() {return this.id;}

    public String getNota(){
        return this.nota;
    }
    
    public String getTesto(){
        return this.testo;
    }
    
    public int getSondaggio_id(){
        return this.sondaggio_id;
    }
    
    public String getTipologia(){
        return this.tipologia;
    }
    
    public int getObbligo(){
        return this.obbligo;
    }

    public String getNomeObbligo() {
        if(obbligo==0) return "Non obbligatoria";
        return "Obbligatoria";
    }

    @Override
    public JSONObject getVincoli() {return this.vincoli;}

    public int getOrdine(){
        return this.ordine;
    }

    @Override
    public void setId(int newId) {this.id = newId;}

    public void setNota(String newNota){
        this.nota = newNota;
    }
    
    public void setTesto(String newTesto){
        this.testo = newTesto;
    }
    
    public void setSondaggio_id(int newSondaggio_id){
         this.sondaggio_id = newSondaggio_id;
    }
    
    public void setTipologia(String newTipologia){
        this.tipologia = newTipologia;
    }
    
    public void setObbligo(int newObbligo){
        this.obbligo = newObbligo;
    }

    public void setOrdine(int newOrdine){
        this.ordine = newOrdine;
    }

    @Override
    public void setVincoli(JSONObject newVincoli) {this.vincoli = newVincoli;}

    public int getMin_length() {
        return min_length;
    }

    public void setMin_length(int min_length) {
        this.min_length = min_length;
    }

    public int getMax_length() {
        return max_length;
    }

    public void setMax_length(int max_length) {
        this.max_length = max_length;
    }

    public int getMin_num() {
        return min_num;
    }

    public void setMin_num(int min_num) {
        this.min_num = min_num;
    }

    public int getMax_num() {
        return max_num;
    }

    public void setMax_num(int max_num) {
        this.max_num = max_num;
    }

    public int getDataSuccessivaOdierna() {
        return dataSuccessivaOdierna;
    }

    public void setDataSuccessivaOdierna(int dataSuccessivaOdierna) {
        this.dataSuccessivaOdierna = dataSuccessivaOdierna;
    }

    public int getMin_chooses() {
        return min_chooses;
    }

    public void setMin_chooses(int min_chooses) {
        this.min_chooses = min_chooses;
    }

    public int getMax_chooses() {
        return max_chooses;
    }

    public void setMax_chooses(int max_chooses) {
        this.max_chooses = max_chooses;
    }

    public String getPattern() {
        return pattern;
    }

    public void setPattern(String pattern) {
        this.pattern = pattern;
    }

    public JSONArray getChooses() {
        return chooses;
    }

    public void setChooses(JSONArray chooses) {
        this.chooses = chooses;
    }

    public List<String> getChoosesArrayList() {
        JSONArray arr =  this.getChooses();
        List<String> list = new ArrayList<String>();
        for(int index = 0; index < arr.length(); index++){
            list.add(arr.getString(index));
        }
        return list;
    }

}
