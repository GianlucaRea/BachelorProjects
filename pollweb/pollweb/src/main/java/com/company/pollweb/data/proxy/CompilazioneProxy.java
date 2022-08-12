package com.company.pollweb.data.proxy;

import com.company.pollweb.data.implementation.CompilazioneImpl;
import com.company.pollweb.framework.data.DataLayer;

public class CompilazioneProxy extends CompilazioneImpl {

    protected boolean dirty;
    protected DataLayer dataLayer;

    public CompilazioneProxy(DataLayer d) {
        super();
        this.dataLayer = d;
        this.dirty = false;
    }

    public void setDirty(boolean dirty) {
        this.dirty = dirty;
    }

    public boolean isDirty() {
        return dirty;
    }

    public void setSondaggioId(int Sondaggio_id){super.setSondaggioId(Sondaggio_id);}

    public void setUtenteId(int utente_id) {super.setId(utente_id);}

}
