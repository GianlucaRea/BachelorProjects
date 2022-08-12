/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.company.pollweb.framework.security;

/**
 *
 * @author Marco Ovidi
 */
public class ValidationField {
    //nome del campo parametro della request
    private String nomeCampo;
    //espressione regolare per il controllo
    private String espressioneRegolare;
    //tipo che dovrà avere dopo il controllo per essere coerente con il DataLayer
    private int tipoCampo;

    public ValidationField(String nomeCampo, String espressioneRegolare, int tipoCampo) {
        this.nomeCampo = nomeCampo;
        this.espressioneRegolare = espressioneRegolare;
        this.tipoCampo = tipoCampo;
    }

    public String getNomeCampo() {
        return nomeCampo;
    }

    public void setNomeCampo(String nomeCampo) {
        this.nomeCampo = nomeCampo;
    }

    public String getEspressioneRegolare() {
        return espressioneRegolare;
    }

    public void setEspressioneRegolare(String espressioneRegolare) {
        this.espressioneRegolare = espressioneRegolare;
    }

    public int getTipoCampo() {
        return tipoCampo;
    }

    public void setTipoCampo(int tipoCampo) {
        this.tipoCampo = tipoCampo;
    }





}