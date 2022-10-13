import{d,u as k,o as t,e as a,b as o,h as c,w as m,F as r,H as h,a as i,g as n,m as y,n as x,C}from"./app.7be3aee7.js";import{J as w}from"./AuthenticationCard.768994b8.js";import{_ as V}from"./AuthenticationCardLogo.10b690c8.js";import{_ as $}from"./Button.4a6e7e8f.js";import{_ as p}from"./Input.89c5c345.js";import{_ as v}from"./Label.a31de62b.js";import{_ as F}from"./ValidationErrors.fdd2b9de.js";import"./_plugin-vue_export-helper.cdc0426e.js";const I={class:"mb-4 text-sm text-gray-600"},T=["onSubmit"],U={key:0},B={key:1},N={class:"flex items-center justify-end mt-4"},H=["onClick"],q={__name:"TwoFactorChallenge",setup(J){const s=d(!1),e=k({code:"",recovery_code:""}),f=d(null),_=d(null),g=async()=>{s.value^=!0,await C(),s.value?(f.value.focus(),e.code=""):(_.value.focus(),e.recovery_code="")},b=()=>{e.post(route("two-factor.login"))};return(P,l)=>(t(),a(r,null,[o(c(h),{title:"Two-factor Confirmation"}),o(w,null,{logo:m(()=>[o(V)]),default:m(()=>[i("div",I,[s.value?(t(),a(r,{key:1},[n(" Please confirm access to your account by entering one of your emergency recovery codes. ")],64)):(t(),a(r,{key:0},[n(" Please confirm access to your account by entering the authentication code provided by your authenticator application. ")],64))]),o(F,{class:"mb-4"}),i("form",{onSubmit:y(b,["prevent"])},[s.value?(t(),a("div",B,[o(v,{for:"recovery_code",value:"Recovery Code"}),o(p,{id:"recovery_code",ref_key:"recoveryCodeInput",ref:f,modelValue:c(e).recovery_code,"onUpdate:modelValue":l[1]||(l[1]=u=>c(e).recovery_code=u),type:"text",class:"mt-1 block w-full",autocomplete:"one-time-code"},null,8,["modelValue"])])):(t(),a("div",U,[o(v,{for:"code",value:"Code"}),o(p,{id:"code",ref_key:"codeInput",ref:_,modelValue:c(e).code,"onUpdate:modelValue":l[0]||(l[0]=u=>c(e).code=u),type:"text",inputmode:"numeric",class:"mt-1 block w-full",autofocus:"",autocomplete:"one-time-code"},null,8,["modelValue"])])),i("div",N,[i("button",{type:"button",class:"text-sm text-gray-600 hover:text-gray-900 underline cursor-pointer",onClick:y(g,["prevent"])},[s.value?(t(),a(r,{key:1},[n(" Use an authentication code ")],64)):(t(),a(r,{key:0},[n(" Use a recovery code ")],64))],8,H),o($,{class:x(["ml-4",{"opacity-25":c(e).processing}]),disabled:c(e).processing},{default:m(()=>[n(" Log in ")]),_:1},8,["class","disabled"])])],40,T)]),_:1})],64))}};export{q as default};
