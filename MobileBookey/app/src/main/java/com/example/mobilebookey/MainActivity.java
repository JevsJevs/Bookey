package com.example.mobilebookey;

import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.KeyEvent;
import android.webkit.WebSettings;
import android.webkit.WebView;

public class MainActivity extends AppCompatActivity {

    WebView FamosaWebv;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        FamosaWebv = (WebView) findViewById(R.id.webview);

        ClientWebv cw = new ClientWebv(this);
        FamosaWebv.setWebViewClient(cw);

        FamosaWebv.loadUrl("https://bookeyhotel.000webhostapp.com/html/indexMob.html");
        WebSettings webSettings = FamosaWebv.getSettings();

        webSettings.setJavaScriptEnabled(true);

    }

    @Override
    public boolean onKeyDown(int keyCode, KeyEvent event) {
        if ((keyCode == KeyEvent.KEYCODE_BACK) && FamosaWebv.canGoBack()) {
            FamosaWebv.goBack();
            return true;
        }
        return super.onKeyDown(keyCode, event);

    }
}
