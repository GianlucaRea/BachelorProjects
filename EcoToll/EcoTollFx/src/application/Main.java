package application;
	
import java.util.List;

import application.front.controller.GlobalData;
import application.model.Autostrada;
import javafx.application.Application;
import javafx.fxml.FXMLLoader;
import javafx.stage.Stage;
import javafx.scene.Scene;
import javafx.scene.layout.AnchorPane;

public class Main extends Application {
	@Override
	public void start(Stage primaryStage) {
		try {
			AnchorPane root = (AnchorPane) FXMLLoader.load(getClass().getClassLoader().getResource("application/front/fxml/Home.fxml"));
			Scene scene = new Scene(root);
			scene.getStylesheets().add(getClass().getResource("application.css").toExternalForm());
			primaryStage.setScene(scene);
			primaryStage.setTitle("EcoToll");
			primaryStage.show();
			
		} catch(Exception e) {
			e.printStackTrace();
		}
	}
	
	public static void main(String[] args) {
		
		GlobalData gd = GlobalData.get();
		List<Autostrada> autostrade = gd.getControllerAutostrada().getAllAutostade();
		
		
		launch(args);
	}
}
