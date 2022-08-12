package application.front.controller;



/**
 * Sample Skeleton for 'CaselloPage.fxml' Controller Class
 */

import java.net.URL;
import java.util.ResourceBundle;

import application.model.Autostrada;
import application.model.Casello;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.scene.control.Button;
import javafx.scene.control.ChoiceBox;
import javafx.scene.control.TextField;
import javafx.scene.input.MouseEvent;

public class CaselloPageController  implements javafx.fxml.Initializable {

	@FXML // ResourceBundle that was given to the FXMLLoader
	private ResourceBundle resources;

	@FXML // URL location of the FXML file that was given to the FXMLLoader
	private URL location;

	@FXML // fx:id="editCaselloInsert"
	private TextField editCaselloInsert; // Value injected by FXMLLoader

	@FXML // fx:id="editKmInsert"
	private TextField editKmInsert; // Value injected by FXMLLoader

	@FXML // fx:id="selectAutostrataInsert"
	private ChoiceBox<String> selectAutostrataInsert; // Value injected by FXMLLoader

	@FXML // fx:id="btnInsert"
	private Button btnInsert; // Value injected by FXMLLoader

	@FXML // fx:id="selectCaselloDelete"
	private ChoiceBox<String> selectCaselloDelete; // Value injected by FXMLLoader

	@FXML // fx:id="btnDelete"
	private Button btnDelete; // Value injected by FXMLLoader

	@FXML // fx:id="editCaselloUpdate"
	private TextField editCaselloUpdate; // Value injected by FXMLLoader

	@FXML // fx:id="selectCaselloUpdate"
	private ChoiceBox<String> selectCaselloUpdate; // Value injected by FXMLLoader

	@FXML // fx:id="editKmUpdate"
	private TextField editKmUpdate; // Value injected by FXMLLoader

	@FXML // fx:id="btnUpdate"
	private Button btnUpdate; // Value injected by FXMLLoader
	
	@FXML
	private ChoiceBox<String> selectAutostrataDelete;
	
	@FXML
	void InsertnewKilometroInsert(MouseEvent event) {

	}

	@FXML
	void SelectMotorwayInsert(MouseEvent event) {

	}

	@FXML
	void writeNewInsertName(MouseEvent event) {

	}

	@FXML
	void onBtnInsert(ActionEvent event) {
		String casello = editCaselloInsert.getText();
		String kilometro = editKmInsert.getText();
		double km = Double.valueOf(kilometro);

		Casello c = new Casello(casello, km);

		int iNdx = selectAutostrataInsert.getSelectionModel().getSelectedIndex();
		String autostradaStr = selectAutostrataInsert.getItems().get(iNdx);

		Autostrada a = new Autostrada(autostradaStr);

		GlobalData.get().getControllerCasello().addCasello(c, a);
	}

	@FXML
	void onBtnDelete(ActionEvent event) {

		int iNdx = selectCaselloDelete.getSelectionModel().getSelectedIndex();
		String caselloDel= selectCaselloDelete.getItems().get(iNdx);

		int iNdx2 = selectAutostrataDelete.getSelectionModel().getSelectedIndex();
		String autostradaCas = selectAutostrataDelete.getItems().get(iNdx2);

		Autostrada a = new Autostrada(autostradaCas);

		for (Casello c : GlobalData.get().getControllerCasello().getAllCas()) {
			if (caselloDel.equals(c.getNome())) {
				GlobalData.get().getControllerCasello().delete(c, a);

			}
		}
	}
	
	@FXML
	void onBtnUpdate (ActionEvent event) {
		
//		String caselloMod = editCaselloInsert.getText();
//		String kilometroMod = editKmInsert.getText();
//		double kmMod = Double.valueOf(kilometroMod);
//		Casello casello = new Casello(caselloMod, kmMod);
//		
//		
//		int iNdx = selectCaselloUpdate.getSelectionModel().getSelectedIndex();  //rimozione
//		String caselloDel= selectCaselloUpdate.getItems().get(iNdx);
//
//		int iNdx2 = selectAutostradaChange.getSelectionModel().getSelectedIndex();
//		String autostradaCas = selectAutostradaChange.getItems().get(iNdx2);
//
//		Autostrada a = new Autostrada(autostradaCas);
//
//		for (Casello Cas : GlobalData.get().getControllerCasello().getAllCas()) {
//			if (caselloDel.equals(Cas.getNome())) {
//				GlobalData.get().getControllerCasello().delete(Cas, a);	
//			}
		String caselloMod = editCaselloInsert.getText();
		String kilometroMod = editKmInsert.getText();
		double kmMod = Double.valueOf(kilometroMod);
		
		for (Casello c : GlobalData.get().getControllerCasello().getAllCas()) {
			if (selectCaselloUpdate.equals(c.getNome())) {
				GlobalData.get().getControllerCasello().updateCasello(c, caselloMod, kmMod);
			}
		}
		
		
		}
		
		
		
		
		
//		int iNdx3 = selectAutostradaUpdate.getSelectionModel().getSelectedIndex(); //Inserimento
//		String autostradaStr = selectAutostradaUpdate.getItems().get(iNdx3);
//		
//		Autostrada Aut = new Autostrada(autostradaStr);
//		
//		GlobalData.get().getControllerCasello().addCasello(casello, Aut);
//
//
//
//	}




	@Override
	public void initialize(URL location, ResourceBundle resources) {
		
		assert editCaselloInsert != null : "fx:id=\"newToolboothNameInsert\" was not injected: check your FXML file 'CaselloPage.fxml'.";
        assert editKmInsert != null : "fx:id=\"newKilometroInsert\" was not injected: check your FXML file 'CaselloPage.fxml'.";
        assert selectAutostrataInsert != null : "fx:id=\"selectMotorwayofInsert\" was not injected: check your FXML file 'CaselloPage.fxml'.";
        assert btnInsert != null : "fx:id=\"InsertButtonToolbooth\" was not injected: check your FXML file 'CaselloPage.fxml'.";
        assert selectCaselloDelete != null : "fx:id=\"selectCaselloDelete\" was not injected: check your FXML file 'CaselloPage.fxml'.";
        assert btnDelete != null : "fx:id=\"btnDelete\" was not injected: check your FXML file 'CaselloPage.fxml'.";
        assert selectAutostrataDelete != null : "fx:id=\"selectAutostrataDelete\" was not injected: check your FXML file 'CaselloPage.fxml'.";
        assert editCaselloUpdate != null : "fx:id=\"editCaselloUpdate\" was not injected: check your FXML file 'CaselloPage.fxml'.";
        assert selectCaselloUpdate != null : "fx:id=\"selectCaselloUpdate\" was not injected: check your FXML file 'CaselloPage.fxml'.";
        assert editKmUpdate != null : "fx:id=\"editKmUpdate\" was not injected: check your FXML file 'CaselloPage.fxml'.";
        assert btnUpdate != null : "fx:id=\"btnUpdate\" was not injected: check your FXML file 'CaselloPage.fxml'.";

		for (Autostrada autostrada : GlobalData.get().getControllerAutostrada().getAllAutostade()) {
			selectAutostrataInsert.getItems().add(autostrada.getNome());
		}

		for (Autostrada autostrada : GlobalData.get().getControllerAutostrada().getAllAutostade()) {
			selectAutostrataDelete.getItems().add(autostrada.getNome());
		}

		for (Casello c: GlobalData.get().getControllerCasello().getAllCas()) {
			selectCaselloDelete.getItems().add(c.getNome());
		}

		for (Casello c: GlobalData.get().getControllerCasello().getAllCas()) {
			selectCaselloUpdate.getItems().add(c.getNome());
		}	
	}
}