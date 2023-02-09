// Color shade changer
export const pSBC=(p,c0,c1,l)=>{
    let r,g,b,P,f,t,h,i=parseInt,m=Math.round,a=typeof(c1)=="string", pSBCr;
    if(typeof(p)!="number"||p<-1||p>1||typeof(c0)!="string"||(c0[0]!='r'&&c0[0]!='#')||(c1&&!a))return null;
    if(!pSBCr)pSBCr=(d)=>{
        let n=d.length,x={};
        if(n>9){
            [r,g,b,a]=d=d.split(","),n=d.length;
            if(n<3||n>4)return null;
            x.r=i(r[3]=="a"?r.slice(5):r.slice(4)),x.g=i(g),x.b=i(b),x.a=a?parseFloat(a):-1
        }else{
            if(n==8||n==6||n<4)return null;
            if(n<6)d="#"+d[1]+d[1]+d[2]+d[2]+d[3]+d[3]+(n>4?d[4]+d[4]:"");
            d=i(d.slice(1),16);
            if(n==9||n==5)x.r=d>>24&255,x.g=d>>16&255,x.b=d>>8&255,x.a=m((d&255)/0.255)/1000;
            else x.r=d>>16,x.g=d>>8&255,x.b=d&255,x.a=-1
        }return x};
    h=c0.length>9,h=a?c1.length>9?true:c1=="c"?!h:false:h,f=pSBCr(c0),P=p<0,t=c1&&c1!="c"?pSBCr(c1):P?{r:0,g:0,b:0,a:-1}:{r:255,g:255,b:255,a:-1},p=P?p*-1:p,P=1-p;
    if(!f||!t)return null;
    if(l)r=m(P*f.r+p*t.r),g=m(P*f.g+p*t.g),b=m(P*f.b+p*t.b);
    else r=m((P*f.r**2+p*t.r**2)**0.5),g=m((P*f.g**2+p*t.g**2)**0.5),b=m((P*f.b**2+p*t.b**2)**0.5);
    a=f.a,t=t.a,f=a>=0||t>=0,a=f?a<0?t:t<0?a:a*P+t*p:0;
    if(h)return"rgb"+(f?"a(":"(")+r+","+g+","+b+(f?","+m(a*1000)/1000:"")+")";
    else return"#"+(4294967296+r*16777216+g*65536+b*256+(f?m(a*255):0)).toString(16).slice(1,f?undefined:-2)
}

// Convert hex to rgb
export function hexToRGB(hex, alpha) {
    var r = parseInt(hex.slice(1, 3), 16),
        g = parseInt(hex.slice(3, 5), 16),
        b = parseInt(hex.slice(5, 7), 16);

    if (alpha) {
        return "rgba(" + r + ", " + g + ", " + b + ", " + alpha + ")";
    } else {
        return "rgb(" + r + ", " + g + ", " + b + ")";
    }
}

export function autoHeight(input) {
    console.log("AutoHeight");
    input.style.minHeight = "1rem";
    input.style.height = "auto";
    input.style.height = (input.scrollHeight) + "px";
    input.style.overflowY = "hidden";
}

// Read a page's GET URL variables and return them as an associative array.
export function getUrlVars()
{
    let queryParam = {};
    let hashes = window.location.search.slice(window.location.search.indexOf('?') + 1).split('&');
    for(let i = 0; i < hashes.length; i++)
    {
        let hash = hashes[i].split('=');
        queryParam[hash[0]] = hash[1];
    }

    return queryParam;
}

let hasError = false;

export function valdiateInput(element, form, controller, errorMessage) {  
    console.log("Validate input");
    if ($(element).val().trim().length !== 0) {
            
        $(element).siblings('.loading').show();
        $.get(
            Settings.base_url + controller,
            {input : $(element).val()},
            function (data) {
                console.log(data);
                let response = JSON.parse(data);
                console.log(response);

                if (!response.data)
                {
                    $(element)
                        .removeClass('success-border')
                        .addClass('danger-border')
                        .parents('.loading-input')
                        .siblings('.text-danger')
                            .text((response.hasOwnProperty('message')) ? response.message : errorMessage)
                            .show();
                    hasError = true;
                }
                else
                {
                    $(element)
                        .removeClass('danger-border')
                        .addClass('success-border')
                        .parents('.loading-input')
                        .siblings('.text-danger')
                            .hide();

                    hasError = false;
                }

                $(element).siblings('.loading').hide();
                $(form).trigger('custom:inputChange', [hasError]);
            }
        );
    }
}


//  Form
export function toggleForm(form, toggle) {
    form.find('input, textarea, button').prop('disabled', toggle);
    $('button[form="' + form.attr('id') + '"]').prop('disabled', toggle);
}

//  Filter
export function changeFilter(element) {
    console.log("changeFilter");
    let radio = $(element);

    radio.prop('checked', true);
    radio.trigger('change');
}


// || Duration
// Start
export function startDurationHandler(e) {
    $('input[data-end="'+e.target.dataset.start+'"]').attr('min', e.target.value);
}

//  End
export function endDurationHandler(e) {
    $('input[data-start="'+e.target.dataset.end+'"]').attr('max', e.target.value);
}