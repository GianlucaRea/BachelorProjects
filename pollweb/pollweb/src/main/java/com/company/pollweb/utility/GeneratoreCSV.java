package com.company.pollweb.utility;

import java.io.File;
import java.io.FileWriter;
import java.io.IOException;
import java.util.List;

public class GeneratoreCSV {

    private GeneratoreCSV(){ }

    public static String nuovaStringaCSV(List<List<String>> result) throws IOException {
        String csvWriter="Domanda,Risposta\n";
        for (List<String> rowData : result) {
            csvWriter += String.join(",", rowData)+"\n";
        }
        return csvWriter;
    }
    public static String nuovaStringaPrivatoCSV(List<List<String>> result) throws IOException {
        String csvWriter="Email,Domanda,Risposta\n";
        for (List<String> rowData : result) {
            csvWriter += String.join(",", rowData)+"\n";
        }
        return csvWriter;
    }
}
