package com.company.pollweb.data.proxy;

import com.company.pollweb.data.implementation.SondaggioImpl;
import com.company.pollweb.framework.data.DataLayer;

public class SondaggioProxy extends SondaggioImpl {

    protected boolean dirty;

    protected DataLayer dataLayer;

    public SondaggioProxy(DataLayer d) {
        super();
        this.dataLayer = d;
        this.dirty = false;
    }

    /*
    @Override
    public Utente getUtente() {
        if (super.getUtente() == null && user_key > 0) {
            try {
                super.setUtente(((UserDAO) dataLayer.getDAO(User.class)).getUser(user_key));
            } catch (DataException ex) {
                Logger.getLogger(UserProxy.class.getName()).log(Level.SEVERE, null, ex);
            }
        }
        return super.getUser();
    }

    */



    @Override
    public void setTitolo(String titolo) {
        super.setTitolo(titolo);
        this.dirty = true;
    }

    @Override
    public void setTestoiniziale(String testoiniziale) {
        super.setTestoiniziale(testoiniziale);
        this.dirty = true;
    }

    @Override
    public void setTestofinale(String testofinale) {
        super.setTestofinale(testofinale);
        this.dirty = true;
    }
    public void setUtenteId(int Nuser_id) {
        super.setUtenteId(Nuser_id);
    }

    public void setDirty(boolean dirty) {
        this.dirty = dirty;
    }

    public boolean isDirty() {
        return dirty;
    }


}
