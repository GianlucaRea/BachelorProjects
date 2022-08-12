 package com.company.pollweb.data.dao;

import com.company.pollweb.data.models.*;
import com.company.pollweb.framework.data.DataException;
import com.company.pollweb.framework.data.DataLayer;
import javax.sql.DataSource;
import java.sql.SQLException;

    public class PollwebDataLayer extends DataLayer {

        public PollwebDataLayer(DataSource dataSource) throws SQLException {
            super(dataSource);
        }

        @Override
        public void init() throws DataException {
            registerDAO(Utente.class, new UtenteDao_MySQL(this));
            registerDAO(Sondaggio.class, new SondaggioDao_MySQL(this));
            registerDAO(Domanda.class, new DomandaDao_MySQL(this));
            registerDAO(Ruolo.class, new RuoloDao_MySQL(this));
            registerDAO(Compilazione.class, new CompilazioneDao_MySQL(this));
        }

        public UtenteDao getUtenteDAO() { return ((UtenteDao) getDAO(Utente.class)); }
        public SondaggioDao getSondaggioDAO() { return ((SondaggioDao) getDAO(Sondaggio.class)); }
        public DomandaDao getDomandaDAO() { return ((DomandaDao) getDAO(Domanda.class)); }
        public RuoloDao getRuoloDAO() { return ((RuoloDao) getDAO(Ruolo.class)); }
        public CompilazioneDao getCompilazioneDAO() { return ((CompilazioneDao) getDAO(Compilazione.class)); }
    }

