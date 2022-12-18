import{u as l,d,o as c,e as u,b as s,h as a,w as r,F as p,H as f,a as e,n as _,g as w,m as b}from"./app.d60119fc.js";import{J as h}from"./AuthenticationCard.c231fa43.js";import{_ as g}from"./AuthenticationCardLogo.415ee36d.js";import{_ as x}from"./Button.430cdf90.js";import{_ as v}from"./Input.2f720e52.js";import{_ as y}from"./Label.15a9759f.js";import{_ as V}from"./ValidationErrors.89b9408d.js";import"./_plugin-vue_export-helper.cdc0426e.js";const C=e("div",{class:"mb-4 text-sm text-gray-600"}," This is a secure area of the application. Please confirm your password before continuing. ",-1),$=["onSubmit"],k={class:"flex justify-end mt-4"},j={__name:"ConfirmPassword",setup(F){const o=l({password:""}),t=d(null),n=()=>{o.post(route("password.confirm"),{onFinish:()=>{o.reset(),t.value.focus()}})};return(B,i)=>(c(),u(p,null,[s(a(f),{title:"Secure Area"}),s(h,null,{logo:r(()=>[s(g)]),default:r(()=>[C,s(V,{class:"mb-4"}),e("form",{onSubmit:b(n,["prevent"])},[e("div",null,[s(y,{for:"password",value:"Password"}),s(v,{id:"password",ref_key:"passwordInput",ref:t,modelValue:a(o).password,"onUpdate:modelValue":i[0]||(i[0]=m=>a(o).password=m),type:"password",class:"mt-1 block w-full",required:"",autocomplete:"current-password",autofocus:""},null,8,["modelValue"])]),e("div",k,[s(x,{class:_(["ml-4",{"opacity-25":a(o).processing}]),disabled:a(o).processing},{default:r(()=>[w(" Confirm ")]),_:1},8,["class","disabled"])])],40,$)]),_:1})],64))}};export{j as default};