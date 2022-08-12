package application.model;

//import java.sql.ResultSet;
//import java.sql.SQLException;


/**
 * Questa classe implementa l'interfacciaVeicolo con il quale metodo 
 * otteniamo la classificazione del veicolo in base alla classe di appartenenza
 * 
 * @author gianlucarea
 *
 */

public class Veicolo implements InterfacciaVeicolo {
   
	private String modello, targa , marca;
	private int peso,anno,num_assi,classe_euro;
	private double altezza;
	

   /**
    * Questo è il costruttore che utilizziamo per creare il veicolo senza tener conto della classe euro.
    * 
    * @param modello del veicolo
    * @param targa del veicolo
    * @param marca del veicolo
    * @param peso del veicolo
    * @param anno del veicolo
    * @param num_assi del veicolo
    * @param altezza del veicolo
    */
	public Veicolo(String modello,String targa,String marca,int peso,int anno,int num_assi,double altezza) {
		 this.modello = modello;
		 this.targa = targa;
		 this.marca = marca;
		 this.peso = peso;
		 this.num_assi = num_assi;
		 this.altezza = altezza;
	}
	
	/**
	 * Questo è il costruttore che utilizziamo per creare il veicolo tenendo conto della classe euro.
	 * 
	 * @param modello del veicolo
	 * @param targa del veicolo
	 * @param marca del veicolo
	 * @param peso del veicolo
	 * @param anno del veicolo
	 * @param num_assi del veicolo
	 * @param classe_euro del veicolo
	 * @param altezza del veicolo
	 */
	public Veicolo(String modello,String targa,String marca,int peso,int anno,int num_assi,int classe_euro,double altezza) {
		 this.modello = modello;
		 this.targa = targa;
		 this.marca = marca;
		 this.peso = peso;
		 this.num_assi = num_assi;
		 this.classe_euro = classe_euro;
		 this.altezza = altezza;
	}
	/**
	 * Metodo costruisce un Veicolo vuoto
	 * Costruttore vuoto
	 * 
	 */
	public Veicolo() {}
	
	/**
	 * Restituisco la classe in base alle classificazioni in categorie per altezza e numero di assi
	 * 
	 */
	public int getClassificazione() {
			if(num_assi <=1 ) return 1;
			if(num_assi == 2 && altezza <= 1.3) return 1;
			if(num_assi == 2 && altezza > 1.3) return 2;
			if(num_assi == 3) return 3;
			if(num_assi == 4) return 4;
			if(num_assi >= 5) return 5;
			return 0;
		}
	
	/**
	 * Metodo che restituisce il modello del veicolo
	 * @return il modello del veicolo
	 */
		public String getModello() {
			return modello;
		}
		
		/**
		 * Metodo che cambia  il modello del veicolo
		 * @param newModello nuovo modello
		 */
		public void setModello(String newModello) {
			this.modello = newModello;
		}
		
		/**
		 * Metodo che restituisce la targa del veicolo
		 * @return la targa del veicolo
		 */
		public String getTarga() {
			return targa;
		}
		
		/**
		 * Metodo che cambia  la targa del veicolo
		 * @param newTarga nuova targa
		 */
		public void setTarga(String newTarga) {
			this.targa = newTarga;
		}
		
		/**
 		* Metodo che restituisce la marca del veicolo
 		* @return la marca del veicolo
 		*/
		public String getMarca() {
			return marca;
		}
		
		/**
		 * Metodo che cambia la marca del veicolo
		 * @param newMarca nuova marca del veicolo
		 */
		public void setMarca(String newMarca) {
			this.marca = newMarca;
		}

		/**
		 * Metodo che restituisce l'anno del veicolo
		 * @return l'anno del veicolo
		 */
		public int getAnno() {
			return anno;
		}
		
		/**
		 * Metodo che cambia  l'anno del veicolo
		 * @param newAnno nuovo anno del veicolo
		 */
		public void setAnno(int newAnno) {
			this.anno = newAnno;
		}
		
		/**
		 * Metodo che restituisce il numero degli Assi del veicolo
		 * @return il numero degli assi del veicolo
		 */
		public int getNumeroAssi() {
			return num_assi;
		}
		
		/**
		 * Metodo che cambia  il numero di assi del veicolo
		 * @param newNum_assi nuovo numero degli assi del veicolo
		 */
		public void setNumeroAssi(int newNum_assi) {
			this.num_assi = newNum_assi;
		}
		
		/**
		 * Metodo che restituisce il peso del veicolo
		 * @return il peso del veicolo
		 */
		public int getPeso() {
			return peso;
		}
		
		/**
		 * Metodo che cambia  il peso del veicolo
		 * @param newPeso nuovo peso del veicolo
		 */
		public void setPeso(int newPeso) {
			this.peso = newPeso;
		}
		
		/**
		 * Metodo che restituisce l'altezza del veicolo
		 * @return altezza del veicolo
		 */
		public double getAltezza() {
			return altezza;
		}
		
		/**
		 * Metodo che cambia  l'altezza del veicolo
		 * @param newAltezza nuova altezza del veicolo
		 */
		public void setAltezza(double newAltezza) {
			this.altezza = newAltezza;
		}
		/**
		 * Metodo che restituisce la classe euro del veicolo
		 * @return la classe euro del veicolo
		 */
		public int getClasseEuro() {
			return this.classe_euro;
		}
		
		/**
		 * Metodo che cambia la classe Euro del veicolo
		 * @param newClasseEuro nuova classe euro del veicolo
		 */
		public void setClasseEuro(int newClasseEuro) {
			this.classe_euro = newClasseEuro;
		}
		
		public String toString() {                       //lavoriamo con le targhe
			return this.getTarga();
		}
	}

