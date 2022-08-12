package application.front.controller;

import application.model.Autostrada;
import application.model.Casello;
import javafx.beans.value.ChangeListener;
import javafx.beans.value.ObservableValue;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.scene.control.Button;
import javafx.scene.control.ChoiceBox;
import javafx.scene.control.TextField;

public class AutostradaPageController {

	 @FXML
	    private TextField editAutostradaInsert;

	    @FXML
	    private Button btnInsert;

	    @FXML
	    private TextField editTariffa;

	    @FXML
	    private Button btnUpdateTariffa;

	    @FXML
	    private TextField EditClasse;

	    @FXML
	    private TextField EditAutostradaTariffa;

	    @FXML
	    private ChoiceBox<String> cbxAutostradaDelete;

	    @FXML
	    private Button btnDelete;

	    @FXML
	    private ChoiceBox<String> cbxAutostradaUpdate;

	    @FXML
	    private TextField editNewAutostradaUpdate;

	    @FXML
	    private Button btnNewAutostradaNameUpdate;

	    @FXML
	    void onBtnElimina(ActionEvent event) {
	    	int iNdx = cbxAutostradaDelete.getSelectionModel().getSelectedIndex();
			String autostradaDel = cbxAutostradaDelete.getItems().get(iNdx);
			
			Autostrada a = new Autostrada (autostradaDel);

	    	cbxAutostradaDelete.getSelectionModel().selectedIndexProperty().addListener(new ChangeListener<Number>() {           //da testare
				@Override
				public void changed(ObservableValue<? extends Number> observableValue, Number oldValue, Number newValue) {
					onSelAutostradaDel(newValue, a);
				}
			});
	    	
			
			GlobalData.get().getControllerAutostrada().deleteAutostradaGlobal(a);
	    }
	    
	    protected void onSelAutostradaDel(Number newValue, Autostrada a) {
	    	for(Casello casello : GlobalData.get().getControllerCasello().getAllCas()) {
				GlobalData.get().getControllerCasello().delete(casello, a);   
				}
		}

	    @FXML
	    void onBtnUpdateTariffa(ActionEvent event) {
	    	String autostrada = EditAutostradaTariffa.getText();
	    	Autostrada a = new Autostrada (autostrada);
	    	String classeVeicolo = EditClasse.getText();
	    	int classe = Integer.parseInt(classeVeicolo);
	    	String tariffa = editTariffa.getText();
	    	double tariffaD = Double.parseDouble(tariffa);
	    	
	    	GlobalData.get().getControllerAutostrada().addTariffa(a, classe, tariffaD);

	    }

	    @FXML
	    void onBtninsert(ActionEvent event) {
	    	String autostrada = editAutostradaInsert.getText();
	    	Autostrada a = new Autostrada(autostrada);
	    	
	    	GlobalData.get().getControllerAutostrada().setAutostradaGlobal(a);
	    }

    


	    @FXML
	    void onBtnUpdate(ActionEvent event) {

		String autostrada = editNewAutostradaUpdate.getText();
		
		int iNdx = cbxAutostradaDelete.getSelectionModel().getSelectedIndex();
		String autostradaUp = cbxAutostradaDelete.getItems().get(iNdx);
    	Autostrada a = new Autostrada(autostradaUp);
    	
    	GlobalData.get().getControllerAutostrada().updateNome(a, autostrada);
    	
	    }
    
    
	  @FXML
	    void initialize() {
		  assert editAutostradaInsert != null : "fx:id=\"editAutostradaInsert\" was not injected: check your FXML file 'AutostradaPage.fxml'.";
	        assert btnInsert != null : "fx:id=\"btnInsert\" was not injected: check your FXML file 'AutostradaPage.fxml'.";
	        assert editTariffa != null : "fx:id=\"editTariffa\" was not injected: check your FXML file 'AutostradaPage.fxml'.";
	        assert btnUpdateTariffa != null : "fx:id=\"btnUpdateTariffa\" was not injected: check your FXML file 'AutostradaPage.fxml'.";
	        assert EditClasse != null : "fx:id=\"EditClasse\" was not injected: check your FXML file 'AutostradaPage.fxml'.";
	        assert EditAutostradaTariffa != null : "fx:id=\"EditAutostradaTariffa\" was not injected: check your FXML file 'AutostradaPage.fxml'.";
	        assert cbxAutostradaDelete != null : "fx:id=\"cbxAutostradaDelete\" was not injected: check your FXML file 'AutostradaPage.fxml'.";
	        assert btnDelete != null : "fx:id=\"btnDelete\" was not injected: check your FXML file 'AutostradaPage.fxml'.";
	        assert cbxAutostradaUpdate != null : "fx:id=\"cbxAutostradaUpdate\" was not injected: check your FXML file 'AutostradaPage.fxml'.";
	        assert editNewAutostradaUpdate != null : "fx:id=\"editNewAutostradaUpdate\" was not injected: check your FXML file 'AutostradaPage.fxml'.";
	        assert btnNewAutostradaNameUpdate != null : "fx:id=\"btnNewAutostradaNameUpdate\" was not injected: check your FXML file 'AutostradaPage.fxml'.";

	        for (Autostrada autostrada : GlobalData.get().getControllerAutostrada().getAllAutostade()) {
	        	cbxAutostradaDelete.getItems().add(autostrada.getNome());
			}
	        for (Autostrada autostrada : GlobalData.get().getControllerAutostrada().getAllAutostade()) {
	        	cbxAutostradaUpdate.getItems().add(autostrada.getNome());
			}
	    }
	  

}
