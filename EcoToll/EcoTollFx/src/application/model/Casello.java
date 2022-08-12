package application.model;

/**
 * Questa è la classe che definisce il Casello , tramite il nome e l'altezza in KM 
 * 
 * @author gianlucarea
 *
 */
public class Casello {
	
		private String nome;
		private double kilometro;
		
	
		/**
		 * Metodo che costruisce un Casello 
		 * @param nome nome del Casello
		 * @param kilometro kilometro del Casello 
		 */
		
		public Casello(String nome, double kilometro) {
			this.nome = nome;
			this.kilometro = kilometro;
		}
		
		/*
		 * Metodo che costruisce un Casello 
		 * Costruttore vuoto
		 * 
		 * 
		 * */
		public Casello () {}

		
		/**
		 * Metodo che restituisce il nome del Casello 
		 * @return nome del Casello
		 */
		public String getNome() {
			return nome;
		}

		/**
		 * Metodo che cambia il nome di un Casello
		 * @param newNome nuovo nome del Casello
		 */
		public void setNome(String newNome) {
			this.nome = newNome;
		}
        
		/**
		 * Metodo che restituisce il kilometro a cui è situato il Casello
		 * @return kilometro del Casello
		 */
		public double getKilometro() {
			return kilometro;
		}
		
		/**
		 * Metodo che cambia il kilometro a cui è situato il Casello 
		 * @param kilometro nuovo kilometro a cui è situato il Casello
		 */
		public void setKilometro(double kilometro) {
			this.kilometro = kilometro;
		}
		
		public String toString() {
			return this.getNome();
		}
}

