import{d as s,p as r,o as l,e as i}from"./app.7be3aee7.js";const d=["value"],p={__name:"Input",props:{modelValue:String},emits:["update:modelValue"],setup(u,{expose:t}){const e=s(null);return r(()=>{e.value.hasAttribute("autofocus")&&e.value.focus()}),t({focus:()=>e.value.focus()}),(a,o)=>(l(),i("input",{ref_key:"input",ref:e,class:"border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm",value:u.modelValue,onInput:o[0]||(o[0]=n=>a.$emit("update:modelValue",n.target.value))},null,40,d))}};export{p as _};
