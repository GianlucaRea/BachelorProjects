package application.model;

import java.util.*;

/**
 * Questa classe rappresenta un autostrada che ha al suo interno 
 * un numero n di Caselli ed ha un nome ed una tariffa unitaria che differisce
 * per ogni autostrada.
 * @author gianlucarea
 *
 */

	public class Autostrada {

		private String nome;
		private TreeMap<Integer, Double> tariffa = new TreeMap<Integer, Double>();
		private HashSet<Casello> listaCaselli = new HashSet<Casello>();
		
		/**
		 * Metodo che costruisce un Autostrada.
		 * @param nome dell'Autostrada
		 * @param tariffa dell'Autostrada
		 * @param caselli dell'Autostrada
		 */
		public Autostrada(String nome, TreeMap<Integer, Double> tariffa, HashSet<Casello> listaCaselli ) {
			this.tariffa = tariffa;
			this.nome = nome;
			this.listaCaselli.addAll(listaCaselli);
		}
		
		/**
		 * Metodo che costruisce un Autostrada senza i caselli
		 * @param nome dell'Autostrada
		 * @param tariffa dell'Autostrada
		 */
		public Autostrada(String nome, TreeMap<Integer, Double> tariffa){
			this.tariffa = tariffa;
			this.nome = nome;
			}
		
		/**
		 * Metodo che costruisce un Autostrada solo col nome
		 * @param nome dell'Autostrada
		 */
		public Autostrada(String nome) {
			this.nome = nome;
			
		}
		
		/**
		 * 
		 * Metodo che costruisce un Autostrada 
		 * Costruttore Vuoto
		 * 
		 * */
		public Autostrada() {}
		
		
		
		/**
		 * Metodo che aggiunge un Caselo ad una Autostrada
		 * @param casello nuovo Casello dell'Autostrada
		 */
		public void addCasello(Casello casello) {
			listaCaselli.add(casello);
		}
		
		/**
		 * Metodo che data l'autostrada ne restituisce il Casello
		 * @param Autostrada
		 * @return caselli che appartendono all'autostrada.
		 */
		public Casello getCasello(String nome) {
			for(Casello c : listaCaselli) {
				if(c.getNome().equals(nome.toLowerCase())) return c;
			}
			return null;
		}
		
		/**
		 * Metodo che dato un un casello controlla se esso è contenuto nell'autostrada
		 * @param casello
		 * @return boolean
		 */
		public boolean searchCasello(Casello c) {
			return listaCaselli.contains(c);
		}
		
		/**
		 * Metodo che dato un un casello lo elimina dall'autostrada
		 * @param casello
		 * @return boolean
		 */
		public boolean deleteCasello(Casello c) {
			return listaCaselli.remove(c);
		}
		
		/**
		 * Metodo che restituisce la tariffa in base alla classificazione del veicolo
		 * @param ClassificazioneVeicolo La classe del veicolo
		 * @return tariffa della tratta 
		 */
		public double getTariffa(int classificazioneVeicolo) {
			return tariffa.get(classificazioneVeicolo);
		}
		
		/**
		 * Metodo che inserisce nella treeMap tariffa una nuova tariffa in base alla classe
		 * @param classe La classe veicolo che verrà aggiunta alla treeMap
		 * @param valore il valore che verrà associato a tale classe
		 * @return
		 */
		public boolean setTariffa(int classe, double valore) {
			if(tariffa.containsKey(classe)) {
				tariffa.remove(classe);
				tariffa.put(classe, valore);
				return tariffa.containsKey(classe);
			}
			tariffa.put(classe, valore);
			return tariffa.containsKey(classe);
		}
		
		public int sizeTariffa() {
			return tariffa.size();
		}
		
		/**
		 * Metodo che restituisce la lista dei Caselli
		 * @return la lista dei Caselli
		 */
		public HashSet<Casello> getListaCaselli(){
			return listaCaselli;
		}
		
		/**
		 * Metodo che restituisce il nome dell'Autostrada
		 * @return il nome dell'autostrada
		 */
		public String getNome()
		{
			return this.nome;
		}
		
		/**
		 * Metodo che cambia il nome dell'Autostrada
		 * @param newNome nuovo nome dell'Autostrada
		 */
		public void setName(String newNome)
		{
			this.nome = newNome;
		}
		
		public String toString(){
	        return this.getNome();
		}

	}