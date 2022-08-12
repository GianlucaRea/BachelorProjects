package com.company.pollweb.data.models;

import org.json.JSONArray;
import org.json.JSONObject;

import java.util.List;

public interface Domanda {

    public int getId();

    public String getNota();

    public String getTesto();

    public int getSondaggio_id();

    public String getTipologia();

    public int getObbligo();

    public String getNomeObbligo();

    public JSONObject getVincoli();

    public int getOrdine();

    public void setId(int newId);

    public void setNota(String newNota);

    public void setTesto(String newTesto);

    public void setSondaggio_id(int newSondaggio_id);

    public void setTipologia(String newTipologia);

    public void setObbligo(int newObbligo);

    public void setOrdine(int newOrdine);

    public void setVincoli(JSONObject newVincoli);

    public int getMin_length();

    public void setMin_length(int min_length);

    public int getMax_length();

    public void setMax_length(int max_length);

    public int getMin_num();

    public void setMin_num(int min_num);

    public int getMax_num();

    public void setMax_num(int max_num);

    public int getDataSuccessivaOdierna();

    public void setDataSuccessivaOdierna(int dataSuccessivaOdierna);

    public int getMin_chooses();

    public void setMin_chooses(int min_chooses);

    public int getMax_chooses();

    public void setMax_chooses(int max_chooses);

    public String getPattern();

    public void setPattern(String pattern);

    public JSONArray getChooses();

    public void setChooses(JSONArray chooses);

    public List<String> getChoosesArrayList();

}
