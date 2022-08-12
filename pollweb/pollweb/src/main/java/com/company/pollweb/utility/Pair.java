package com.company.pollweb.utility;

public class Pair {

    private int l;
    private String r;

    public Pair(int l, String r){
        this.l = l;
        this.r = r;
    }

    public int getL(){ return l; }

    public String getR(){ return r; }

    public void setL(int l){ this.l = l; }

    public void setR(String r){ this.r = r; }
}