/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.company.pollweb.data.implementation;

import com.company.pollweb.data.models.Responsabile;

/**
 *
 * @author alessandrodorazio
 */
public class ResponsabileImpl extends UtenteImpl implements Responsabile {
    public ResponsabileImpl() {
        super();
        this.ruolo_id = 2;
    }
    
    public ResponsabileImpl(String nome, String cognome, String email) {
        super();
        this.ruolo_id = 2;
    }
    
    @Override
    public String getNomeRuolo() {
        return "Responsabile";
    }
}
