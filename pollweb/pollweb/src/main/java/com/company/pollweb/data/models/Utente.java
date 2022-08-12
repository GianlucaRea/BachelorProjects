package com.company.pollweb.data.models;

public interface Utente {

    public String getNome();

    public String getCognome();

    public String getNomeCompleto();

    public String getPassword();

    public String getEmail();

    public int getId();

    public int getRuolo();

    public String getNomeRuolo();

    public void setNome(String newNome);

    public void setCognome(String newCognome);

    public void setEmail(String newEmail);

    public void setPassword(String newPassword);

    public void setRuolo(int newRuoloId);

    public void setId(int newId);

}
