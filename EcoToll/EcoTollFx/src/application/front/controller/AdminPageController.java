package application.front.controller;

import application.model.Autostrada;
import application.model.Casello;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.scene.control.Button;
import javafx.scene.control.ChoiceBox;
import javafx.scene.control.ListView;
import javafx.scene.control.TextField;
import javafx.scene.input.ContextMenuEvent;
import javafx.scene.input.MouseEvent;
import javafx.stage.Stage;

public class AdminPageController {

    @FXML
    private ChoiceBox<String> selectMotorway;

    @FXML
    private TextField showTariffa;

    @FXML
    private ListView<String> showCaselloList;

    @FXML
    private Button goAutostradasetting;

    @FXML
    private ChoiceBox<String> selectCasello;

    @FXML
    private TextField showKilometro;

    @FXML
    private Button goCasellosetting;

    @FXML
    private Button logoutButton;

    @FXML
    void dologout(MouseEvent event) {
    	

    }
    
//    void onSelectCasello (MouseEvent event) {
//    	showKilometro.setText("22");
//    }


    @FXML
    void gotoAutostradaSetting(MouseEvent event) {
    	try {
			FXMLLoader fxmlLoader = new FXMLLoader(getClass().getClassLoader().getResource("application/front/fxml/AutostradaPage.fxml"));
			Parent root1 = (Parent) fxmlLoader.load();
			Stage stage = new Stage();
			stage.setScene(new Scene(root1));  
			stage.show();
		} catch(Exception e) {
			e.printStackTrace();
		}

    }

    @FXML
    void gotoCaselloSetting(MouseEvent event) {
    	try {
			FXMLLoader fxmlLoader = new FXMLLoader(getClass().getClassLoader().getResource("application/front/fxml/CaselloPage.fxml"));
			Parent root1 = (Parent) fxmlLoader.load();
			Stage stage = new Stage();
			stage.setScene(new Scene(root1));  
			stage.show();
		} catch(Exception e) {
			e.printStackTrace();
		}

    }
    
    @FXML
    void initialize() {
        assert selectMotorway != null : "fx:id=\"selectMotorway\" was not injected: check your FXML file 'AdminPage.fxml'.";
        assert showTariffa != null : "fx:id=\"showTariffa\" was not injected: check your FXML file 'AdminPage.fxml'.";
        assert showCaselloList != null : "fx:id=\"showCaselloList\" was not injected: check your FXML file 'AdminPage.fxml'.";
        assert goAutostradasetting != null : "fx:id=\"goAutostradasetting\" was not injected: check your FXML file 'AdminPage.fxml'.";
        assert selectCasello != null : "fx:id=\"selectCasello\" was not injected: check your FXML file 'AdminPage.fxml'.";
        assert showKilometro != null : "fx:id=\"showKilometro\" was not injected: check your FXML file 'AdminPage.fxml'.";
        assert goCasellosetting != null : "fx:id=\"goCasellosetting\" was not injected: check your FXML file 'AdminPage.fxml'.";
        assert logoutButton != null : "fx:id=\"logoutButton\" was not injected: check your FXML file 'AdminPage.fxml'.";

        for (Autostrada autostrada : GlobalData.get().getControllerAutostrada().getAllAutostade()) {
        	selectMotorway.getItems().add(autostrada.getNome());
		}
        for (Casello c: GlobalData.get().getControllerCasello().getAllCas()) {
        	selectCasello.getItems().add(c.getNome());
		}
    }

}

