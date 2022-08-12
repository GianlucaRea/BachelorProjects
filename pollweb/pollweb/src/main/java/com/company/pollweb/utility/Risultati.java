package com.company.pollweb.utility;

import java.util.List;
import java.util.Map;

public class Risultati {
    private String email;
    private Map<Integer, String> risposte;

    public Risultati() {
        this.email = null;
    }

    public Risultati(String email) {
        this.email = email;
    }

    public Risultati(Map<Integer, String> risposte) {
        this.email = null;
        this.risposte = risposte;
    }

    public Risultati(String email, Map<Integer, String> risposte) {
        this.email = email;
        this.risposte = risposte;
    }

    public void setEmail(String email) {
        this.email = email;
    }

    public void setRisposte(Map<Integer, String> risposte) {
        this.risposte = risposte;
    }

    public String getEmail() {
        if(this.email != null) return email;
        return "Email sconosciuta";
    }

    public Map<Integer, String> getRisposte() {
        return risposte;
    }
}
