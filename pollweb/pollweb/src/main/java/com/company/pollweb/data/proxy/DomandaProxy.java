package com.company.pollweb.data.proxy;

import com.company.pollweb.framework.data.DataLayer;
import com.company.pollweb.data.implementation.DomandaImpl;
import org.json.JSONObject;

public class DomandaProxy extends DomandaImpl {

    protected boolean dirty;

    protected DataLayer dataLayer;

    public DomandaProxy(DataLayer d) {
        super();
        this.dataLayer = d;
        this.dirty = false;
    }

    public void setDirty(boolean dirty) {
        this.dirty = dirty;
    }

    public void setNota(String Nota){
        super.setNota(Nota);
    }

    public void setTesto(String Testo){
        super.setTesto(Testo);
    }

    public void setSondaggio_id(int Sondaggio_id){
        super.setSondaggio_id(Sondaggio_id);
    }

    public void setTipologia(String Tipologia){super.setTipologia(Tipologia);}

    public void setObbligo(int newObbligo){
        super.setObbligo(newObbligo);
    }

    public void setVincoli(JSONObject Vincoli) {super.setVincoli(Vincoli);}

    public boolean isDirty() {
        return dirty;
    }
}
