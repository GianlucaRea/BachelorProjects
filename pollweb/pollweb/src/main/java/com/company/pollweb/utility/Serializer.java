package com.company.pollweb.utility;

import org.json.*;

/**
 * @author gianlucarea
 */

public class Serializer {


    public static JSONObject sceltaSingolaToJSON(String chooses){
        String JSON = "{\"chooses\": ["+chooses+"]}";
        JSONObject obj = new JSONObject(JSON);
        return obj;
    }

    public static JSONObject dataToJSON(int data){
        String JSON = "{\"date\": "+data+"}";
        JSONObject obj = new JSONObject(JSON);
        return obj;
    }

    public static JSONObject StringToJSON(String JSON){
        JSONObject obj;
        System.out.println(JSON);
        if(JSON.startsWith("{")) {
            obj = new JSONObject(JSON);
        } else {
            obj = new JSONObject("{}");
        }
        return obj;
    }

    public static JSONObject testobreveToJSONF(int max_number, String pattern){
        String JSON = "{\"max_length\": "+max_number+",\"pattern\": "+pattern+"}";
        JSONObject obj = new JSONObject(JSON);
        return obj;
    }
    public static JSONObject ToJSONN() {
        String JSON = "{}";
        JSONObject obj = new JSONObject(JSON);
        return obj;
    }
    public static JSONObject testobreveToJSONNP(int max_number){
        String JSON = "{\"max_length\": "+max_number+"}";
        JSONObject obj = new JSONObject(JSON);
        return obj;
    }
    public static JSONObject testobreveToJSONNM( String pattern){
        String JSON = "{\"pattern\": "+pattern+"}";
        JSONObject obj = new JSONObject(JSON);
        return obj;
    }
    public static JSONObject testolungoToJSONF(int min_number, int max_number, String pattern){
        String JSON = "{\"min_length\": "+min_number+",\"max_length\": "+max_number+",\"pattern\": "+pattern+"}";
        JSONObject obj = new JSONObject(JSON);
        return obj;
    }

    public static JSONObject testolungoToJSONNm(int max_length, String pattern) {
        String JSON = "{\"max_length\": "+max_length+",\"pattern\": "+pattern+"}";
        JSONObject obj = new JSONObject(JSON);
        return obj;
    }

    public static JSONObject testolungoToJSONP(int max_length, int min_length) {
        String JSON = "{\"min_length\": "+min_length+",\"max_length\": "+max_length+"}";
        JSONObject obj = new JSONObject(JSON);
        return obj;
    }

    public static JSONObject testolungoToJSONNPm(int max_length) {
        String JSON = "{\"max_length\": "+max_length+"}";
        JSONObject obj = new JSONObject(JSON);
        return obj;
    }

    public static JSONObject testolungoToJSONM(int min_length, String pattern) {
        String JSON = "{\"min_length\": "+min_length+",\"pattern\": "+pattern+"}";
        JSONObject obj = new JSONObject(JSON);
        return obj;
    }

    public static JSONObject testolungoToJSONNPM(int min_length) {
        String JSON = "{\"min_length\": "+min_length+"}";
        JSONObject obj = new JSONObject(JSON);
        return obj;
    }

    public static JSONObject testolungoToJSONNMn(String pattern) {
        String JSON = "{\"pattern\": "+pattern+"}";
        JSONObject obj = new JSONObject(JSON);
        return obj;
    }

    public static JSONObject numeroToJSONF(int max_num, int min_num) {
        String JSON = "{\"min_num\": "+min_num+",\"max_num\": "+max_num+"}";
        JSONObject obj = new JSONObject(JSON);
        return obj;
    }

    public static JSONObject numeroToJSONm(int max_num) {
        String JSON = "{\"max_num\": "+max_num+"}";
        JSONObject obj = new JSONObject(JSON);
        return obj;
    }

    public static JSONObject testobreveToJSONM(int min_num) {
        String JSON = "{\"min_num\": "+min_num+"}";
        JSONObject obj = new JSONObject(JSON);
        return obj;
    }

    public static JSONObject sceltaMultiplaToJSONF(String chooses, int min_chooses, int max_chooses){
        String JSON = "{\"chooses\": ["+chooses+"],\"min_chooses\": "+min_chooses+",\"max_chooses\": "+max_chooses+"}";
        JSONObject obj = new JSONObject(JSON);
        return obj;
    }

    public static JSONObject sceltaMultiplaToJSONNm(String chooses, int max_chooses) {
        String JSON = "{\"chooses\": ["+chooses+"],\"max_chooses\": "+max_chooses+"}";
        JSONObject obj = new JSONObject(JSON);
        return obj;

    }

    public static JSONObject sceltaMultiplaToJSONNM(String chooses, int min_chooses) {
        String JSON = "{\"chooses\": ["+chooses+"],\"min_chooses\": "+min_chooses+"}";
        JSONObject obj = new JSONObject(JSON);
        return obj;

    }
}
