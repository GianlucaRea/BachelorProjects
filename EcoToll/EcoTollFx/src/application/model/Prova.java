/* package application.model;

import java.util.HashSet;

public class Prova {

	public static void main(String[] args) {
		
		//il mio Veicolo 
		 Veicolo macchina = new Veicolo("Barchetta", "FR345AY", "FIAT",1400, 2006, 2, 1.22);
		
		// 3 nuovi caselli
		Casello c1 = new Casello("Atina", 300);
		Casello c2 = new Casello("Sora", 317);
		Casello c5 = new Casello("Non usato", 340);
		
		//3 nuovi caselli
		Casello c3 = new Casello("prova 1", 257);
		Casello c4 = new Casello("prova 2", 223);
		Casello c6 = new Casello("Non usato", 260);
		
		//Array delle tariffe per ogni veicolo di classi da 1 a 5
		double[] tariffe1 = new double[] {1,2,3,4,5};
		double[] tariffe2 = new double[] {(double) 1.5,(double) 2.5,(double) 3.5,(double) 4.5,(double) 5.5};
		
		//Racchiudo i caselli che voglio passare all' autostrada A14  in un hashSet (che passerò come parametro)
		HashSet<Casello> listaA14 = new HashSet<Casello>();
		listaA14.add(c1);
		listaA14.add(c2);
		listaA14.add(c5);
		//Assegno tariffe e caselli alle relative autostrade (alla seconda la faccio aggiungendone uno alla volta)
		Autostrada autostrada1 = new Autostrada("A14", tariffe1, listaA14);
		Autostrada autostrada2 = new Autostrada("A55",tariffe2);
		autostrada2.addCasello(c3);
		autostrada2.addCasello(c4);
		autostrada2.addCasello(c6);
		
		//Genero i miei percorsi sulle relative autostrade (supponiamo che tali percorsi ci siano dati da input dai biglietti)
		Percorso p1 = new Percorso(c1,c2, autostrada1);
		Percorso p2 = new Percorso(c3,c4, autostrada2);
		
		//Stampo il pedaggio da pagare su tali percorsi utilizzando macchina come veicolo
		System.out.print(Pedaggio.calcolaPedaggio(macchina, p1));
		System.out.println(" ");
		System.out.print(Pedaggio.calcolaPedaggio(macchina, p2));
		
	}

}
 
 */

