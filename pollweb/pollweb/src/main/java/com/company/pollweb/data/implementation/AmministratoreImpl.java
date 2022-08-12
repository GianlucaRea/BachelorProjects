/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.company.pollweb.data.implementation;

import com.company.pollweb.data.models.Amministratore;

/**
 *
 * @author alessandrodorazio
 */
public class AmministratoreImpl extends ResponsabileImpl implements Amministratore {
    @Override
    public String getNomeRuolo() {
        return "Amministratore";
    }
}
