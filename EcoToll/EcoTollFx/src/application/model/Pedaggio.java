package application.model;

/**
 * La classe pedaggio serve al calcolo del pedaggio, e perciò  
 * fornisce soltando metodi per il calcolo.
 * @author gianlucarea
 *
 */
	 

	public abstract class Pedaggio {
			
		/**
		 * Metodo per il calcolo del Pedaggio in cui è specificata l'iva in caso di cambio di essa per questo specifico calcolo
		 * @param v Veicolo che Effettua il tragitto
		 * @param iva Iva Da Pagare per il tragitto
		 * @param percorso Traggito che effettua il Veicolo
		 * @return Il risultato del calcolo del pedaggio con iva
		 */
			//Metodo per eventuale futuro nel quale può essere specificata l'iva in caso di cambio per questo specifico calcolo
			public static double calcolaPedaggio(Veicolo v, int iva, Percorso percorso ) {				
				double risultato = 0;
				
				risultato += percorso.getDistance() * percorso.getAutostrada().getTariffa(v.getClassificazione());
				risultato = risultato + risultato * iva / 100;
				risultato = arrotondamento(risultato);
				return risultato;
			}
			
			/**
			 * Metodo per il calcolo del Pedaggio con IVA attuale per questo specifico calcolo
			 * @param v Veicolo che percorre il tragitto
			 * @param percorsos traggiot che effettua il veicolo
			 * @return Il risultato del calcolo del pedaggio con iva attuale
			 */
			public static double calcolaPedaggio(Veicolo v, Percorso percorso) {
				
				double risultato = 0;
				int iva = 22;
				
				risultato += percorso.getDistance() * percorso.getAutostrada().getTariffa(v.getClassificazione());
				risultato = risultato + risultato * iva / 100;
				risultato = arrotondamento(risultato);
				return risultato;
			}
			
			
			/**
			 * Metodo per l'arrotondamento ai 10 centesimi con taglio a due cifre decimali
			 * @param i Valore da arrotondare
			 * @return Il valore arrotondato
			 */
			
			private static double arrotondamento(double i) {
				
				i *= 100;
				i = java.lang.Math.round(i);
				double modulo = i % 10;
				if(modulo <= 5) i -= modulo;
				else i = i + 10 - modulo;
				return i / 100;
			}
	}

