(function(){
  'use strict';
  const menuButton=document.querySelector('.menu-toggle');
  const navigation=document.querySelector('.site-nav');
  if(menuButton&&navigation){menuButton.addEventListener('click',function(){const open=navigation.classList.toggle('open');menuButton.setAttribute('aria-expanded',String(open));menuButton.textContent=open?'Close':'Menu';});}

  const symbols={KES:'KSh',USD:'$',GBP:'£',EUR:'€'};
  const roundSteps={KES:500,USD:25,GBP:25,EUR:25};
  const format=function(kes,currency){if(currency==='KES')return 'KSh '+(Math.ceil(kes/500)*500).toLocaleString('en-US');const rate=(window.atelierData&&atelierData.rates[currency])||1;const value=Math.ceil((kes/rate)/roundSteps[currency])*roundSteps[currency];return symbols[currency]+value.toLocaleString('en-US');};
  document.querySelectorAll('[data-estimator]').forEach(function(root){
    let type=50000,pages=0,currency=localStorage.getItem('atelierCurrency')||'KES';
    const result=root.querySelector('[data-estimate]');
    const update=function(){
      root.querySelectorAll('[data-currency]').forEach(b=>b.classList.toggle('active',b.dataset.currency===currency));
      if(type===null){result.textContent='Scope review required';}
      else{let total=type+pages;root.querySelectorAll('[data-addon].active').forEach(b=>total+=Number(b.dataset.addon));result.textContent=format(total,currency)+' – '+format(Math.round(total*1.25),currency);}
      document.querySelectorAll('[data-estimate-field]').forEach(f=>f.value=result.textContent);
    };
    root.querySelectorAll('[data-currency]').forEach(b=>b.addEventListener('click',()=>{currency=b.dataset.currency;localStorage.setItem('atelierCurrency',currency);update();}));
    root.querySelectorAll('[data-type]').forEach(b=>b.addEventListener('click',()=>{root.querySelectorAll('[data-type]').forEach(x=>x.classList.remove('active'));b.classList.add('active');type=b.dataset.value==='manual'?null:Number(b.dataset.value);update();}));
    root.querySelectorAll('[data-pages]').forEach(b=>b.addEventListener('click',()=>{root.querySelectorAll('[data-pages]').forEach(x=>x.classList.remove('active'));b.classList.add('active');pages=Number(b.dataset.pages);update();}));
    root.querySelectorAll('[data-addon]').forEach(b=>b.addEventListener('click',()=>{b.classList.toggle('active');update();}));
    update();
  });
})();
