(function (config) {
  var ba = navigator.userAgent.toLowerCase(),
    e = window,
    da = document,
    fa = da.documentElement;

  function T(a) {
    return ba.indexOf(a) !== -1;
  }
  var ga = /([a-z0-9]*\d+[a-z0-9]*)/;

  function ha() {
    var a = ia;
    if (!a) return null;
    var a = a.toLowerCase(),
      b = null;
    if (b = a.match(/angle \((.*)\)/)) a = b[1], a = a.replace(/\s*direct3d.*$/, "");
    a = a.replace(/\s*\([^\)]*wddm[^\)]*\)/, "");
    if (a.indexOf("intel") >= 0) {
      b = ["Intel"];
      a.indexOf("mobile") >= 0 && b.push("Mobile");
      (a.indexOf("gma") >= 0 || a.indexOf("graphics media accelerator") >= 0) && b.push("GMA");
      if (a.indexOf("haswell") >= 0) b.push("Haswell");
      else if (a.indexOf("ivy") >= 0) b.push("HD 4000");
      else if (a.indexOf("sandy") >= 0) b.push("HD 3000");
      else if (a.indexOf("ironlake") >= 0) b.push("HD");
      else {
        a.indexOf("hd") >= 0 && b.push("HD");
        var c = a.match(ga);
        c && b.push(c[1].toUpperCase());
      }
      return b = b.join(" ");
    }
    // eslint-disable-next-line no-return-assign
    return a.indexOf("nvidia") >= 0 || a.indexOf("quadro") >= 0 || a.indexOf("geforce") >= 0 || a.indexOf("nvs") >= 0 ? (b = ["nVidia"], a.indexOf("geforce") >= 0 && b.push("geForce"), a.indexOf("quadro") >= 0 && b.push("Quadro"), a.indexOf("nvs") >= 0 && b.push("NVS"), a.match(/\bion\b/) && b.push("ION"), a.match(/gtx\b/) ? b.push("GTX") : a.match(/gts\b/) ? b.push("GTS") : a.match(/gt\b/) ? b.push("GT") : a.match(/gs\b/) ? b.push("GS") : a.match(/ge\b/)
      ? b.push("GE") : a.match(/fx\b/) && b.push("FX"), (c = a.match(ga)) && b.push(c[1].toUpperCase().replace("GS", "")), a.indexOf("titan") >= 0 ? b.push("TITAN") : a.indexOf("ti") >= 0 && b.push("Ti"), b = b.join(" ")) : a.indexOf("amd") >= 0 || a.indexOf("ati") >= 0 || a.indexOf("radeon") >= 0 || a.indexOf("firegl") >= 0 || a.indexOf("firepro") >= 0 ? (b = ["AMD"], a.indexOf("mobil") >= 0 && b.push("Mobility"), c = a.indexOf("radeon"), c >= 0 && b.push("Radeon"), a.indexOf("firepro") >= 0 ? b.push("FirePro") : a.indexOf("firegl") >= 0 && b.push("FireGL"), a.indexOf("hd") >= 0 &&
				b.push("HD"), c >= 0 && (a = a.substring(c)), (c = a.match(ga)) && b.push(c[1].toUpperCase().replace("HD", "")), b = b.join(" ")) : a.substring(0, 100);
  }
  var ja = "microsoft basic render driver;vmware svga 3d;Intel 965GM;Intel B43;Intel G41;Intel G45;Intel G965;Intel GMA 3600;Intel Mobile 4;Intel Mobile 45;Intel Mobile 965".split(";"),
    ka = "ActiveXObject" in e,
    la = "devicePixelRatio" in e && e.devicePixelRatio > 1 || ka && "matchMedia" in e && e.matchMedia("(min-resolution:144dpi)") && e.matchMedia("(min-resolution:144dpi)").matches,
    oa = T("windows nt"),
    ra = ba.search(/windows nt [1-5]\./) !== -1,
    sa = ba.search(/windows nt 5\.[12]/) !== -1,
    ta = ra && !sa;
  T("windows nt 10");
  var ua = T("windows phone"),
    va = T("macintosh"),
    wa = T("Mb2345Browser"),
    xa = T("ipad;") || T("ipad "),
    ya = xa && la,
    za = T("ipod touch;"),
    Aa = T("iphone;") || T("iphone "),
    Ba = Aa || xa || za,
    Ca = Ba && ba.search(/ os [456]_/) !== -1;
  Ba && ba.search(/ os [4-8]_/);
  var Ea = Ba && ba.search(/ os [78]_/) !== -1;
  Ba && T("os 8_");
  var Fa = Ba && T("os 10_"),
    Ga = T("android"),
    Ha = ba.search(/android [123]/) !== -1,
    Ka = T("android 4");
  Ga && ba.search(/android [1-4]/) === -1 || ba.search(/android 4.4/);
  var La = Ga ? "android" : Ba ? "ios" : oa ? "windows" : va ? "mac" : "other",
    Ma = ka && !e.XMLHttpRequest,
    Na = ka && !da.querySelector,
    Oa = ka && !da.addEventListener,
    Pa = ka && T("ie 9"),
    Qa = ka && T("msie 10"),
    Ra = ka && T("rv:11"),
    Sa = T("edge"),
    Ta = T("qtweb"),
    Ua = T("ucbrowser"),
    Va = T("alipay") || Ga && Ua,
    Wa = T("miuibrowser"),
    Xa = T("micromessenger"),
    Ya = T("mqqbrowser"),
    Za = T("baidubrowser"),
    chrome = (T("chrome") || T("crios")) && !Xa && !Za && !Ya && !Sa && !Wa,
    ab = chrome && T("chromium"),
    bb = chrome && !ab && parseInt(ba.split("chrome/")[1]) > 30,
    cb = T("firefox"),
    db = cb &&
			parseInt(ba.split("firefox/")[1]) > 27,
    eb = (va || Ba) && T("safari") && T("version/"),
    fb = va && eb && parseInt(ba.split("version/")[1]) > 7,
    gb = Ba && T("aliapp"),
    hb = Ba && (!Ya && !Ua && !Xa && !chrome && !cb && !eb || gb),
    ib = Ga || Ba || ua || T("mobile"),
    jb = e.navigator && e.navigator.msPointerEnabled && !!e.navigator.msMaxTouchPoints,
    kb = e.navigator && e.navigator.pointerEnabled && !!e.navigator.maxTouchPoints,
    lb = kb || jb,
    mb = "ontouchstart" in da || lb,
    nb = (function () {
      if (!ib) return e.devicePixelRatio || 1;
      var a = document.getElementsByTagName("meta");
      if (window.parent &&
				window.parent !== window) {
        try {
          if (window.parent.location.origin === window.location.origin) a = window.parent.document.getElementsByTagName("meta");
          else return 1;
        } catch (b) {
          return 1;
        }
      }
      for (var c = a.length - 1; c >= 0; c -= 1) {
        if (a[c].name === "viewport") {
          var c = a[c].content,
            d; c.indexOf("initial-scale") !== -1 && (d = parseFloat(c.split("initial-scale=")[1]));
          a = c.indexOf("minimum-scale") !== -1 ? parseFloat(c.split("minimum-scale=")[1]) : 0;
          c = c.indexOf("maximum-scale") !== -1 ? parseFloat(c.split("maximum-scale=")[1]) : Infinity;
          if (d) {
            if (c >=
							a) return d > c ? c : d < a ? a : d;
          } else if (c >= a) return a >= 1 ? 1 : Math.min(c, 1);
          console && console.log && console.log("viewport\u53c2\u6570\u4e0d\u5408\u6cd5");
          return null;
        }
      }
    }()),
    ob = la && (!ib || !!nb && nb >= 1),
    pb = ka && "transition" in fa.style,
    qb = !!da.createElementNS && !!da.createElementNS("http://www.w3.org/2000/svg", "svg").createSVGRect,
    rb = da.createElement("canvas"),
    sb = !(!rb || !rb.getContext),
    vb = window.URL || window.webkitURL,
    wb = !ka && !(Ua && Ga) && window.Worker && vb && vb.createObjectURL && window.Blob,
    xb = "",
    ia = "",
    yb = 0,
    zb = {
      alpha: !0,
      antialias: !0,
      depth: !1,
      failIfMajorPerformanceCaveat: !0,
      preserveDrawingBuffer: !0,
      stencil: !1
    },
    Ab = (function () {
      if (!sb || !wb || hb) return !1;
      for (var a = ["webgl", "experimental-webgl", "moz-webgl"], b = null, c = 0; c < a.length; c += 1) {
        try {
          b = rb.getContext(a[c], zb);
        } catch (d) { }
        if (b) {
          if (b.drawingBufferWidth !== rb.width || b.drawingBufferHeight !== rb.height) break;
          if (!b.getShaderPrecisionFormat || !b.getParameter || !b.getExtension) break;
          yb = b.getParameter(b.MAX_RENDERBUFFER_SIZE);
          var f = b.getParameter(b.MAX_VIEWPORT_DIMS);
          if (!f) break;
          yb = Math.min(yb,
            f[0], f[1]);
          eb && La === "mac" && (yb = Math.min(yb, 4096));
          f = Math.max(screen.width, screen.height);
          ob && (f *= Math.min(2, window.devicePixelRatio || 1));
          if (f > yb) break;
          if (b.getShaderPrecisionFormat(35632, 36338).precision < 23 || b.getShaderPrecisionFormat(35633, 36338).precision < 23) break;
          ia = b.getExtension("WEBGL_debug_renderer_info") ? b.getParameter(37446) : null;
          if ((b = ha()) && ja.indexOf(b) !== -1) break;
          xb = a[c];
          return !0;
        }
      }
      return !1;
    }()),
    Bb = Ab && !ib && (bb || db || fb) && (La === "mac" || La === "windows"),
    Cb = !sb || Ta || ua || ib && cb || Pa || Ca || ya || za ||
			Ha || T("gt-n710") || ta,
    Db = !Cb && !Bb && (Ka || Ea || Ba && Xa || !ib),
    Eb = Bb ? "vw" : Cb ? "d" : Db ? "dv" : "v",
    Fb = T("webkit"),
    Gb = "WebKitCSSMatrix" in e && "m11" in new window.WebKitCSSMatrix(),
    Hb = "MozPerspective" in fa.style,
    Ib = "OTransition" in fa.style,
    Jb = pb || Gb || Hb || Ib,
    Kb = void 0 !== config[8] ? config[8] : !0,
    Lb = void 0 !== config[9] ? config[9] : !0,
    Mb = void 0 !== config[10] ? config[10] : !0,
    Nb = void 0 !== config[11] ? config[11] : !0,
    Ob = void 0 !== config[12] ? config[12] : null,
    Pb = !qb && ib && sb,
    Qb = !0;
  try {
    if (typeof e.localStorage === "undefined") Qb = !1;
    else {
      var Rb = (new Date()).getTime() + "";
      e.localStorage.setItem("_test", Rb);
      e.localStorage.getItem("_test") !== Rb && (Qb = !1);
      e.localStorage.removeItem("_test");
    }
  } catch (Sb) {
    Qb = !1;
  }
  config.j = {
    size: Aa ? 100 : Ga ? 200 : 500,
    Hu: va,
    e8: oa,
    LK: Ba,
    SZ: Fa,
    Gg: Ga,
    O4: Ha,
    KJ: Va,
    lr: La,
    nz: Za,
    d7: Ya,
    MM: eb,
    s3: Xa,
    bo: ka,
    Mg: Ma,
    Vq: Na,
    h6: Pa,
    EZ: Qa,
    nd: Oa,
    GZ: ka && !Ra,
    y_: wa,
    qj: Qb,
    ud: Qb && Nb && !ib && chrome,
    Qo: Ob,
    geolocation: ib || ka && !Oa || Sa,
    MC: Ua && !chrome,
    chrome: chrome,
    Tz: la && chrome,
    FJ: cb,
    U: ib,
    I6: ib && Fb,
    D_: ib && Gb,
    H6: ib && e.opera,
    Rc: la,
    UC: nb,
    ha: ob,
    vd: mb,
    J_: jb,
    hM: kb,
    iM: lb,
    eX: parseInt(ba.split("chrome/")[1]) >= 57,
    q3: Fb,
    g6: pb,
    r3: Gb,
    A5: Hb,
    R6: Ib,
    kW: Jb,
    oj: qb,
    $q: sb,
    XK: wb,
    Ov: Mb,
    QW: Ab,
    Zd: Bb,
    n3: xb,
    o3: zb,
    nK: ia,
    x_: yb,
    G3: !1,
    yY: Kb,
    ne: Kb &&
			!Cb,
    yW: Kb ? Eb : "d",
    ho: Lb && !!e.WebSocket && !Za,
    P6: Pb,
    g0: sb || Pb ? "c" : "d"
  };
  var e = window,
    Tb = {
      overlay: ["style"],
      "AMap.IndoorMap": ["AMap.CustomLayer", "cvector"],
      "AMap.MarkerList": ["AMap.TplUtils"]
    },
    Ub = "http map anip layers overlay0 brender mrender".split(" ");
  config.Fd = "main";
  config.j.vd && (Ub += ",touch", config.Fd += "t");
  config.j.U || (Ub += ",mouse", config.Fd += "m");
  config.Fd += "c";
  config.j.ne && (config.Fd += "v", Ub += ",vectorlayer,overlay", config.j.Zd ? (config.Fd += "w", Ub += ",wgl") : (config.Fd += "cg", Ub += ",cmng,cgl"));
  if (config[7]) {
    for (var Vb = [], Wb = config[7].split(","), Xb = 0; Xb < Wb.length; Xb += 1) {
      var Yb = Wb[Xb];
      Tb[Yb] && Vb.push.apply(Vb, Tb[Yb]);
      Vb.push(Yb);
    }
    Ub += "," + Vb.join(",");
    config.Fd += config[7].replace(",", "").replace(eval("/AMap./gi"), "");
  }
  config.Nn = Tb;
  Ub += ",sync";
  config.AN = Ub.split(",");
  window.AMap = window.AMap || {};
  config.wg = "1503546983737";
  var Zb = window.AMap.TC = {},
    mc = config[2].split(",")[0],
    nc = mc + "/theme/v" + config[4] + "/style1503546983737.css",
    oc = document.head || document.getElementsByTagName("head")[0];
  if (oc) {
    var pc = document.createElement("link");
    pc.setAttribute("rel", "stylesheet");
    pc.setAttribute("type", "text/css");
    pc.setAttribute("href", nc);
    oc.insertBefore(pc, oc.firstChild);
  } else document.write("<link rel='stylesheet' href='" + nc + "'/>");

  function qc(a) {
    var b = document,
      c = b.createElement("script");
    c.charset = "utf-8";
    c.src = a;
    (a = b.body || oc) && a.appendChild(c);
  }

  function rc() {
    for (var a = mc + "/maps/main?v=" + config[4] + "&key=" + config[0] + "&m=" + config.AN.join(",") + "&vrs=1503546983737", b = document.getElementsByTagName("script"), c, d = 0; d < b.length; d += 1) {
      if (b[d].src.indexOf(mc.split(":")[1] + "/maps?") === 0) {
        c = b[d];
        break;
      }
    }

    //		var cnzz_s_tag = document.createElement('script');
    //		cnzz_s_tag.type = 'text/javascript';
    //		cnzz_s_tag.async = true;
    //		cnzz_s_tag.charset = 'utf-8';
    //		cnzz_s_tag.src = a;
    //		var root_s = document.getElementsByTagName('script')[0];
    //		root_s.parentNode.insertBefore(cnzz_s_tag, root_s);

    config[5] || c && c.async ? qc(a) : (document.write('<script id="amap_main_js" src=\'' + a + "'  type='text/javascript'>\x3c/script>"), setTimeout(function () {
      document.getElementById("amap_main_js") || qc(a);
    }, 1));
  }
  var sc = (new Date()).getTime();
  Zb.__load__ = function (a) {
    a(config, sc);
    Zb.__load__ = null;
  };
  try {
    if (window.localStorage) {
      var tc = window.localStorage["_AMap_" + config.Fd],
        uc = !1;
      tc ? (tc = JSON.parse(tc), tc.version === config.wg ? (eval(tc.script), Zb.loaded = !0) : uc = !0) : uc = !0;
      if (uc) { for (Xb in window.localStorage) window.localStorage.hasOwnProperty(Xb) && Xb.indexOf("_AMap_") === 0 && window.localStorage.removeItem(Xb); };
    }
  } catch (vc) { }
  Zb.loaded || (rc(), delete config.AN);
})(["d3a5c9286bb4f21b2cd3054951030da4", [120.856804, 30.675593, 122.247149, 31.872716, 121.472644, 31.231706], "http://webapi.amap.com", 1, "1.3", null, "310000", "AMap.Autocomplete", true, true, true, true, "1515503728-1"])
;
