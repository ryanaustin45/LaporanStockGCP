<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- Font Awesome Icons -->
<link rel="stylesheet" href="{{asset('AdminLTE/plugins/fontawesome-free/css/all.min.css')}}">
<!-- Theme style -->
<link rel="stylesheet" href="{{asset('AdminLTE/dist/css/adminlte.min.css')}}">

<link rel="stylesheet" href="{{asset('AdminLTE/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('AdminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('AdminLTE/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">

<script nonce="e0009de4-cf1c-4f2e-82ae-668d96ab1caa">
    (function(w, d) {
        ! function(bg, bh, bi, bj) {
            bg[bi] = bg[bi] || {};
            bg[bi].executed = [];
            bg.zaraz = {
                deferred: [],
                listeners: []
            };
            bg.zaraz.q = [];
            bg.zaraz._f = function(bk) {
                return async function() {
                    var bl = Array.prototype.slice.call(arguments);
                    bg.zaraz.q.push({
                        m: bk,
                        a: bl
                    })
                }
            };
            for (const bm of ["track", "set", "debug"]) bg.zaraz[bm] = bg.zaraz._f(bm);
            bg.zaraz.init = () => {
                var bn = bh.getElementsByTagName(bj)[0],
                    bo = bh.createElement(bj),
                    bp = bh.getElementsByTagName("title")[0];
                bp && (bg[bi].t = bh.getElementsByTagName("title")[0].text);
                bg[bi].x = Math.random();
                bg[bi].w = bg.screen.width;
                bg[bi].h = bg.screen.height;
                bg[bi].j = bg.innerHeight;
                bg[bi].e = bg.innerWidth;
                bg[bi].l = bg.location.href;
                bg[bi].r = bh.referrer;
                bg[bi].k = bg.screen.colorDepth;
                bg[bi].n = bh.characterSet;
                bg[bi].o = (new Date).getTimezoneOffset();
                if (bg.dataLayer)
                    for (const bt of Object.entries(Object.entries(dataLayer).reduce(((bu, bv) => ({
                            ...bu[1],
                            ...bv[1]
                        })), {}))) zaraz.set(bt[0], bt[1], {
                        scope: "page"
                    });
                bg[bi].q = [];
                for (; bg.zaraz.q.length;) {
                    const bw = bg.zaraz.q.shift();
                    bg[bi].q.push(bw)
                }
                bo.defer = !0;
                for (const bx of [localStorage, sessionStorage]) Object.keys(bx || {}).filter((bz => bz.startsWith("_zaraz_"))).forEach((by => {
                    try {
                        bg[bi]["z_" + by.slice(7)] = JSON.parse(bx.getItem(by))
                    } catch {
                        bg[bi]["z_" + by.slice(7)] = bx.getItem(by)
                    }
                }));
                bo.referrerPolicy = "origin";
                bo.src = "/cdn-cgi/zaraz/s.js?z=" + btoa(encodeURIComponent(JSON.stringify(bg[bi])));
                bn.parentNode.insertBefore(bo, bn)
            };
            ["complete", "interactive"].includes(bh.readyState) ? zaraz.init() : bg.addEventListener("DOMContentLoaded", zaraz.init)
        }(w, d, "zarazData", "script");
    })(window, document);
</script>