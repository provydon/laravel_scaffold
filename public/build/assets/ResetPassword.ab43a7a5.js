import{u,o as c,e as f,b as s,h as a,w as l,F as _,H as w,a as r,n as V,g as b,m as k}from"./app.7be3aee7.js";import{J as v}from"./AuthenticationCard.768994b8.js";import{_ as g}from"./AuthenticationCardLogo.10b690c8.js";import{_ as x}from"./Button.4a6e7e8f.js";import{_ as i}from"./Input.89c5c345.js";import{_ as m}from"./Label.a31de62b.js";import{_ as y}from"./ValidationErrors.fdd2b9de.js";import"./_plugin-vue_export-helper.cdc0426e.js";const P=["onSubmit"],$={class:"mt-4"},h={class:"mt-4"},C={class:"flex items-center justify-end mt-4"},J={__name:"ResetPassword",props:{email:String,token:String},setup(n){const d=n,o=u({token:d.token,email:d.email,password:"",password_confirmation:""}),p=()=>{o.post(route("password.update"),{onFinish:()=>o.reset("password","password_confirmation")})};return(F,e)=>(c(),f(_,null,[s(a(w),{title:"Reset Password"}),s(v,null,{logo:l(()=>[s(g)]),default:l(()=>[s(y,{class:"mb-4"}),r("form",{onSubmit:k(p,["prevent"])},[r("div",null,[s(m,{for:"email",value:"Email"}),s(i,{id:"email",modelValue:a(o).email,"onUpdate:modelValue":e[0]||(e[0]=t=>a(o).email=t),type:"email",class:"mt-1 block w-full",required:"",autofocus:""},null,8,["modelValue"])]),r("div",$,[s(m,{for:"password",value:"Password"}),s(i,{id:"password",modelValue:a(o).password,"onUpdate:modelValue":e[1]||(e[1]=t=>a(o).password=t),type:"password",class:"mt-1 block w-full",required:"",autocomplete:"new-password"},null,8,["modelValue"])]),r("div",h,[s(m,{for:"password_confirmation",value:"Confirm Password"}),s(i,{id:"password_confirmation",modelValue:a(o).password_confirmation,"onUpdate:modelValue":e[2]||(e[2]=t=>a(o).password_confirmation=t),type:"password",class:"mt-1 block w-full",required:"",autocomplete:"new-password"},null,8,["modelValue"])]),r("div",C,[s(x,{class:V({"opacity-25":a(o).processing}),disabled:a(o).processing},{default:l(()=>[b(" Reset Password ")]),_:1},8,["class","disabled"])])],40,P)]),_:1})],64))}};export{J as default};
