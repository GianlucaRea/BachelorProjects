package com.company.pollweb.data.proxy;

import com.company.pollweb.data.implementation.UtenteImpl;
import com.company.pollweb.framework.data.DataLayer;

public class UtenteProxy extends UtenteImpl {
    protected boolean dirty;

    protected DataLayer datalayer;
    protected int role_key;

    public UtenteProxy(DataLayer d) {
        super();
        this.role_key = 0;
        this.datalayer = d;
        this.dirty = false;
    }


    //TODO implementare getRuolo

    @Override
    public void setEmail(String email) {
        super.setEmail(email);
        this.dirty = true;
    }

    @Override
    public void setPassword(String password) {
        super.setPassword(password);
        this.dirty = true;
    }

    public void setRuolo(int role_key) {
        this.role_key = role_key;
        //resettiamo la cache dell'autore
        //reset author cache
        super.setRuolo(role_key);
    }

    //Proxy methods
    public void setDirty(boolean dirty) {
        this.dirty = dirty;
    }

    public boolean isDirty() {
        return dirty;
    }
}


