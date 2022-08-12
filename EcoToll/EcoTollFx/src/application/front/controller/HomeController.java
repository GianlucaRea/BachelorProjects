package application.front.controller;

import java.net.URL;
import java.util.ResourceBundle;

import application.model.Autostrada;
import application.model.Casello;
import application.model.Veicolo;
import javafx.beans.value.ChangeListener;
import javafx.beans.value.ObservableValue;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.scene.control.Alert;
import javafx.scene.control.Button;
import javafx.scene.control.ChoiceBox;
import javafx.scene.control.PasswordField;
import javafx.scene.control.TextField;
import javafx.scene.input.MouseEvent;
import javafx.stage.Stage;

public class HomeController implements javafx.fxml.Initializable{

	@FXML
	protected TextField usernamefield;

	@FXML
	protected Button loginButton;

	@FXML
	protected PasswordField passwordField;

	@FXML
	protected ChoiceBox<String> showEntryTollbooth;

	@FXML
	protected ChoiceBox<String> showExitToolbooth;

	@FXML
	protected Button calculusButton;

	@FXML
	protected TextField result;

	@FXML
	protected TextField licensePlate;

	@FXML
	protected ChoiceBox<String> showMotorwayPay;
	
	 @FXML
	    private TextField IVA;

	@FXML
	void doCalculus(MouseEvent event) {		
		String targa = licensePlate.getText();
		Veicolo veicoloTargato = null;
		String iva;
		iva = IVA.getText();
		
		if (IVA.getText().equals("")) {
			Alert alert1 = new Alert(Alert.AlertType.INFORMATION);
			alert1.setTitle("EcoToll");
			alert1.setHeaderText("IVA non trovata");
			alert1.showAndWait();
			return;
		}

		double IVA1 = Double.parseDouble(iva);
		IVA1 = IVA1 / 100;
		
		veicoloTargato = GlobalData.get().getControllerVeicolo().getVeicoloGlobal(targa);

		if (veicoloTargato == null) {
			Alert alert = new Alert(Alert.AlertType.INFORMATION);
			alert.setTitle("EcoToll");
			alert.setHeaderText("Veicolo non trovato");
			alert.setContentText(targa);
			alert.showAndWait();
			return;
		}
		
		int classeVeicolo = veicoloTargato.getClassificazione();

		int iNdx = showEntryTollbooth.getSelectionModel().getSelectedIndex();
		String daCasello = showEntryTollbooth.getItems().get(iNdx);
		double daKm = 0.0;

		iNdx = showExitToolbooth.getSelectionModel().getSelectedIndex();
		String aCasello = showExitToolbooth.getItems().get(iNdx);
		double aKm = 0.0;
		
		double distanza = 0.0;

		for (Casello cas : GlobalData.get().getControllerCasello().getAllCas())  {
			if (cas.getNome().equals(daCasello))  {
				daKm = cas.getKilometro();
			}

			if (cas.getNome().equals(aCasello))  {
				aKm = cas.getKilometro();
			}
		}
		
		distanza = daKm - aKm;
		if (distanza < 0.0)
			distanza = -distanza;

		iNdx = showMotorwayPay.getSelectionModel().getSelectedIndex();
		String autostrada = showMotorwayPay.getItems().get(iNdx);
		Autostrada a = new Autostrada(autostrada);
		
		double tariffa = GlobalData.get().getControllerAutostrada().getTariffa(a, classeVeicolo);
		tariffa = tariffa * distanza;
		
		double tariffaIVA = tariffa * IVA1;
		tariffa = tariffa + tariffaIVA;
		
		tariffa *= 100;
		tariffa = java.lang.Math.round(tariffa);
		double modulo = tariffa % 10;
		if(modulo <= 5) tariffa -= modulo;
		else tariffa = tariffa + 10 - modulo;
		tariffa = tariffa / 100;

		String tariffaS;
		tariffaS= String.valueOf(tariffa).toString();
		

		
		System.out.println(classeVeicolo+ " " + "Targa " + targa + " Autostrada " + autostrada + " Da " + daCasello +  " " + daKm + " a " + aCasello + " " + aKm + " - " + distanza + " " + tariffa);
		
		result.setText(tariffaS);

	}


	@FXML
	void enterLicensePlate(MouseEvent event) {

	}

	@FXML
	void loginAdmin(MouseEvent event) {

	}

	@FXML
	void onBtnCalcola(ActionEvent event) {


	}

	@FXML
	void onBtnLogin(ActionEvent event) {

		String utente = null;
		String password = null;	
		utente = usernamefield.getText();
		password = passwordField.getText();
		
		if (GlobalData.get().getControllerLogin().getAmministratoreGlobal(utente, password)) {
			
			usernamefield.clear();
			passwordField.clear();
			
			try {
				FXMLLoader fxmlLoader = new FXMLLoader(getClass().getClassLoader().getResource("application/front/fxml/AdminPage.fxml"));
				Parent root1 = (Parent) fxmlLoader.load();
				Stage stage = new Stage();
				stage.setScene(new Scene(root1));
				stage.show();
			} catch(Exception e) {
				e.printStackTrace();
			}
		}
		}

	@FXML
	void returnResult(ActionEvent event) {

	}

	@FXML
	void selectAutostradaPedaggio(MouseEvent event) {
	}

	@FXML
	void selectEntryTollbooth(MouseEvent event) {

	}

	@FXML
	void selectExitToolbooth(MouseEvent event) {

	}

	@Override
	public void initialize(URL arg0, ResourceBundle arg1) {
		for (Autostrada autostrada : GlobalData.get().getControllerAutostrada().getAllAutostade()) {
			showMotorwayPay.getItems().add(autostrada.getNome());
		}
		showMotorwayPay.getSelectionModel().selectedIndexProperty().addListener(new ChangeListener<Number>() {
			@Override
			public void changed(ObservableValue<? extends Number> observableValue, Number oldValue, Number newValue) {
				onSelChangedShowMotorwayPay(newValue);
			}
		});

	}

	protected void onSelChangedShowMotorwayPay(Number newValue) {
		System.out.println(showMotorwayPay.getItems().get((Integer) newValue));
		showEntryTollbooth.getItems().clear();
		showExitToolbooth.getItems().clear();
		for(Casello casello : GlobalData.get().getControllerCasello().getAllCas()) {
			showEntryTollbooth.getItems().add(casello.getNome());
			showExitToolbooth.getItems().add(casello.getNome());
		}
	}
}