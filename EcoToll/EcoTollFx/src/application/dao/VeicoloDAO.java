package application.dao;


import java.util.List;

import application.model.Veicolo;

/**
 * 
 * INTERFACCIA DAO Veicolo
 * getVeicolo -> restituisce il veicolo nel database data la targa;
 * insertVeicolo -> inserisce il veicolo nel veicolo;
 */

public interface VeicoloDAO {

	public Veicolo getVeicolo(String t);
	
	public boolean insertVeicolo(Veicolo x);
	
	public boolean deleteVeicolo (Veicolo x);
    
	public List<Veicolo> getAllVeicolo();
}
