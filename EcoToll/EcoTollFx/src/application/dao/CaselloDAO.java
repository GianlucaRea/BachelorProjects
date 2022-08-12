package application.dao;

import java.util.*;

import application.model.Autostrada;
import application.model.Casello;


/**
 * INTERFACCIA DAO CASELLO
 * getListOfCasello -> restituisce la lista di tutti i caselli nel database;
 * deleteCasello -> elimina un casello dal database;
 * addCasello -> aggiungi un casello nel database;
 * updateCasello -> modifica il nome ed il kilometro del casello
 * updateNome -> modifica il nome del casello
 * updateKm -> modifica il kilometro del casello
 */

public interface CaselloDAO {

    public List<Casello> getListOfCasello();
	
	public boolean deleteCasello (Casello c, Autostrada a);
				 
	public boolean addCasello (Casello c, Autostrada a);
	
	public boolean updateCasello(Casello c, String n, double s);
	
	public boolean updateNome (Casello c, String n);
	
	public boolean updateKm (Casello c, double s);
	
}
