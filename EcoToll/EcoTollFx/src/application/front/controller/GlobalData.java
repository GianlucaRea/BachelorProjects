package application.front.controller;

import application.controller.ControllerAutostrada;
import application.controller.ControllerCasello;
import application.controller.ControllerLogin;
import application.controller.ControllerVeicolo;


public class GlobalData {
	private static GlobalData instance;
	ControllerAutostrada controllerAutostrada;
	ControllerCasello controllerCasello;
	private ControllerVeicolo controllerVeicolo;
	ControllerLogin controllerLogin;
	
	//private casello c;
	private GlobalData() {
		
	}
	
	public static GlobalData get() {
		if (instance == null){
			instance = new GlobalData();
			instance.init();
		}
		return instance;
	}
	
	private void init() {
		controllerAutostrada = ControllerAutostrada.getIstance();
		controllerCasello = ControllerCasello.getIstance();
		controllerVeicolo = new ControllerVeicolo();
		controllerLogin = ControllerLogin.getIstance();
	}

	public ControllerAutostrada getControllerAutostrada() {
		return controllerAutostrada;
	}
	
	public ControllerCasello getControllerCasello() {
		return controllerCasello;
	}

	public ControllerVeicolo getControllerVeicolo() {
		return controllerVeicolo;
	}
	
	public ControllerLogin getControllerLogin() {
		return controllerLogin;
	}

}