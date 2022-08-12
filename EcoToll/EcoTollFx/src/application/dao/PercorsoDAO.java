package application.dao;

import application.model.Percorso;

/**
 * 
 * INTERFACCIA DAO Percorso
 * getVeicolo -> restituisce il percorso nel database;
 */

public interface PercorsoDAO {

	public Percorso getPercorso(String p);
}
