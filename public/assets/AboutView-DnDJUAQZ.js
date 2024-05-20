import{_ as A,N as z,i as m,r as i,o as b,c as q,a as n,b as r,w as a,F as U,d as c,e as y,t as M,f as k,g as N,h as B}from"./index-GmIBqQ4r.js";const D={components:{Navbar:z},data(){return{errorSnackbar:!1,selectedSubcategory:"",subcategories:[],otherCategory:"",recaptchaWidget:null,rules:{email:[e=>!!e||"Email is required",e=>/.+@.+\..+/.test(e)||"Email must be valid"]},email:"",emailErrors:[],selectedCategory:"",feedbackCategories:[],subject:"",name:"",feedback:"",loading:!1,successMessage:""}},computed:{showSubcategoryField(){return this.subcategories.length>0},showOtherCategoryField(){const e=this.feedbackCategories.find(t=>t.id===this.selectedCategory);return e&&e.name==="Other"},subjectErrors(){const e=[];return this.subject||e.push("Subject is required"),e},feedbackErrors(){const e=[];return this.feedback||e.push("Feedback is required"),e},categoryErrors(){const e=[];return this.selectedCategory||e.push("Feedback Category is required"),e},subcategoryErrors(){const e=[];return this.selectedSubcategory||e.push("Subcategory is required"),e}},mounted(){this.fetchFeedbackCategories(),this.loadRecaptchaScript(),this.fetchSubcategories()},methods:{async fetchSubcategories(){try{if(!this.selectedCategory){console.error("Selected category is empty");return}const e=await m.get(`/feedback-categories/${this.selectedCategory}/feedback_sub_categories`);this.subcategories=e.data,console.log("Subcategories:",this.subcategories)}catch(e){console.error("Error fetching subcategories:",e)}},loadRecaptchaScript(){const e=document.createElement("script");e.src="https://www.google.com/recaptcha/enterprise.js?render=6Lc3Da8pAAAAAKBHdGzsitOwjjUPh6ttkrkGbkTw",e.onload=()=>{this.initializeRecaptcha()},document.head.appendChild(e)},initializeRecaptcha(){grecaptcha.enterprise.execute("6Lc3Da8pAAAAAKBHdGzsitOwjjUPh6ttkrkGbkTw",{action:"submit"}).then(e=>{this.submitFeedback()}).catch(e=>{console.error("reCAPTCHA verification error:",e)})},async fetchFeedbackCategories(){try{const e=await m.get("/feedback-categories");this.feedbackCategories=e.data,console.log("Feedback categories:",this.feedbackCategories)}catch(e){console.error("Error fetching feedback categories:",e)}},async submitFeedback(){this.loading=!0;try{if(!this.selectedCategory||!this.selectedSubcategory||!this.subject||!this.feedback){this.errorSnackbar=!0;return}const e=this.selectedSubcategory,t=await m.post("/feedback",{category_id:this.selectedCategory,subcategory_id:e,subject:this.subject,name:this.name,email:this.email,feedback:this.feedback,other_category:this.otherCategory});console.log("Response from server:",t),this.successMessage=t.data.message,console.log("Success message:",this.successMessage),this.selectedCategory="",this.selectedSubcategory="",this.subject="",this.name="",this.email="",this.feedback="",this.otherCategory="",setTimeout(()=>{this.successMessage=""},4e3)}catch(e){console.error("Error submitting feedback:",e)}finally{this.loading=!1}}},watch:{selectedCategory(e,t){e!==t&&this.fetchSubcategories()}}},L=n("br",null,null,-1),O=n("br",null,null,-1),P=n("div",{id:"recaptchaContainer"},null,-1),R=n("p",{class:"text-center mt-2",style:{"font-size":"12px"}}," Your feedback will be treated with utmost urgency ",-1),G=n("img",{src:B,alt:"iLabAfrica Logo",style:{"max-width":"300px"}},null,-1),T=n("h3",{style:{color:"white","text-transform":"uppercase"}},"Contact",-1),H=n("p",{style:{color:"white","font-size":"16px","text-transform":"none"}},"Address: Strathmore University Student Centre, Keri Road",-1),K=n("p",{style:{color:"white","font-size":"16px","text-transform":"none"}},"Phone: +254 703 034 616",-1),I=n("p",{style:{color:"white","font-size":"16px","text-transform":"none"}},"Email: ilabafrica@strathmore.edu",-1),Q=n("p",{style:{color:"white","font-size":"16px","text-transform":"none"}},"Mon-Fri: 8:00AM - 5:00PM",-1),W=n("h3",{style:{color:"white","text-transform":"uppercase"}},"Quick Links",-1),Y=n("ul",{style:{"list-style-type":"none",padding:"0"}},[n("li",null,[n("a",{href:"/",style:{color:"white","text-decoration":"none","text-transform":"none"}},"Home")]),n("li",null,[n("a",{href:"/feedback",style:{color:"white","text-decoration":"none","text-transform":"none"}},"Give Feedback")])],-1),J=n("p",{style:{color:"white","text-align":"center",margin:"0","text-transform":"none","font-size":"17px"}}," © 2024 @iLabAfrica, Strathmore University. All rights reserved. ",-1);function X(e,t,Z,$,s,l){const v=i("Navbar"),x=i("v-card-title"),w=i("v-alert"),g=i("v-select"),d=i("v-text-field"),C=i("v-textarea"),h=i("v-icon"),p=i("v-btn"),S=i("v-form"),V=i("v-sheet"),E=i("v-card"),f=i("v-container"),F=i("v-snackbar"),u=i("v-col"),_=i("v-row"),j=i("v-footer");return b(),q(U,null,[n("div",null,[r(v),r(f,null,{default:a(()=>[r(E,{elevation:"3",style:{"border-radius":"5px"},width:"100%"},{default:a(()=>[r(V,{class:"about-section",variant:"outlined"},{default:a(()=>[r(x,{class:"text-center",style:{"background-color":"#02338D",color:"white"}},{default:a(()=>[c("My Feedback")]),_:1}),L,s.successMessage?(b(),y(w,{key:0,type:"success",outlined:"",dense:""},{default:a(()=>[c(M(s.successMessage),1)]),_:1})):k("",!0),O,r(S,{onSubmit:N(l.submitFeedback,["prevent"]),class:"px-3 py-2"},{default:a(()=>[r(g,{modelValue:s.selectedCategory,"onUpdate:modelValue":t[0]||(t[0]=o=>s.selectedCategory=o),items:s.feedbackCategories,"item-title":"name","item-value":"id",label:"Feedback Category*",required:"","error-messages":l.categoryErrors,variant:"underlined","prepend-inner-icon":"mdi-arrow-up-down",dense:"",style:{"text-transform":"capitalize"}},null,8,["modelValue","items","error-messages"]),l.showOtherCategoryField?(b(),y(d,{key:0,modelValue:s.otherCategory,"onUpdate:modelValue":t[1]||(t[1]=o=>s.otherCategory=o),label:"Specify Other Category",variant:"underlined",dense:"",style:{"text-transform":"capitalize"}},null,8,["modelValue"])):k("",!0),r(g,{modelValue:s.selectedSubcategory,"onUpdate:modelValue":t[2]||(t[2]=o=>s.selectedSubcategory=o),items:s.subcategories,"item-title":"name","item-value":"id",label:"Subcategory*",required:"","error-messages":l.subcategoryErrors,variant:"underlined","prepend-inner-icon":"mdi-arrow-up-down",dense:"",style:{"text-transform":"capitalize"}},null,8,["modelValue","items","error-messages"]),r(d,{modelValue:s.subject,"onUpdate:modelValue":t[3]||(t[3]=o=>s.subject=o),label:"Subject*",required:"",rules:[o=>!!o||"Subject is required"],"error-messages":l.subjectErrors,variant:"underlined","prepend-inner-icon":"mdi-text-long",dense:""},null,8,["modelValue","rules","error-messages"]),r(d,{modelValue:s.name,"onUpdate:modelValue":t[4]||(t[4]=o=>s.name=o),label:"Name (optional)",variant:"underlined","prepend-inner-icon":"mdi-account",dense:"",style:{"text-transform":"capitalize"}},null,8,["modelValue"]),r(d,{modelValue:s.email,"onUpdate:modelValue":t[5]||(t[5]=o=>s.email=o),label:"Email (optional)",type:"email",style:{"text-transform":"capitalize"},variant:"underlined","prepend-inner-icon":"mdi-email","error-messages":s.emailErrors,dense:""},null,8,["modelValue","error-messages"]),r(C,{modelValue:s.feedback,"onUpdate:modelValue":t[6]||(t[6]=o=>s.feedback=o),label:"Feedback*",required:"",rules:[o=>!!o||"Feedback is required"],"error-messages":l.feedbackErrors,variant:"underlined","prepend-inner-icon":"mdi-text",dense:""},null,8,["modelValue","rules","error-messages"]),P,r(p,{type:"submit",color:"#02338D",class:"mx-auto",loading:s.loading,dense:"",style:{width:"100%"}},{default:a(()=>[r(h,{class:"mr-4"},{default:a(()=>[c("mdi-send")]),_:1}),c(" Submit ")]),_:1},8,["loading"]),R]),_:1},8,["onSubmit"])]),_:1})]),_:1})]),_:1}),r(F,{modelValue:s.errorSnackbar,"onUpdate:modelValue":t[8]||(t[8]=o=>s.errorSnackbar=o),color:"error",top:""},{default:a(()=>[c(" Please fill in all required fields. "),r(p,{text:"",onClick:t[7]||(t[7]=o=>s.errorSnackbar=!1),icon:"",color:"transparent",elevation:"0"},{default:a(()=>[r(h,null,{default:a(()=>[c("mdi-close")]),_:1})]),_:1})]),_:1},8,["modelValue"])]),r(j,{style:{"background-color":"#02338D"}},{default:a(()=>[r(f,null,{default:a(()=>[r(_,{align:"center"},{default:a(()=>[r(u,{cols:"12",md:"4",class:"text-center"},{default:a(()=>[G]),_:1}),r(u,{cols:"12",md:"4"},{default:a(()=>[T,H,K,I,Q]),_:1}),r(u,{cols:"12",md:"4"},{default:a(()=>[W,Y]),_:1})]),_:1}),r(_,null,{default:a(()=>[r(u,{cols:"12"},{default:a(()=>[J]),_:1})]),_:1})]),_:1})]),_:1})],64)}const te=A(D,[["render",X]]);export{te as default};
