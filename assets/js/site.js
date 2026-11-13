(function(){
  'use strict';

  const menuButton=document.querySelector('.menu-toggle');
  const navigation=document.querySelector('.site-nav');

  if(menuButton&&navigation){
    menuButton.addEventListener('click',function(){
      const open=navigation.classList.toggle('open');
      menuButton.setAttribute('aria-expanded',String(open));
      menuButton.textContent=open?'Close':'Menu';
    });
  }

  const symbols={
    KES:'KSh',
    USD:'$',
    GBP:'£',
    EUR:'€'
  };

  const roundSteps={
    KES:500,
    USD:25,
    GBP:25,
    EUR:25
  };

  const projectTypes={
    website:50000,
    commerce:135000,
    redesign:50000,
    mobile:null
  };

  const projectLabels={
    website:'Business Website',
    commerce:'E-commerce',
    redesign:'Website Redesign',
    mobile:'Mobile App Development'
  };

  const pageLabels={
    '0':'1–3 pages',
    '15000':'4–6 pages',
    '30000':'7+ pages'
  };

  const addonLabels={
    copywriting:'Copywriting',
    seo:'SEO & Analytics',
    marketing:'Launch Marketing'
  };

  const supportedCurrencies=['USD','GBP','EUR','KES'];

  let currency=localStorage.getItem('atelierCurrency')||'USD';

  if(!supportedCurrencies.includes(currency)){
    currency='USD';
  }

  let projectType=localStorage.getItem('atelierProjectType')||'website';

  if(!Object.prototype.hasOwnProperty.call(projectTypes,projectType)){
    projectType='website';
  }

  let pages=Number(localStorage.getItem('atelierPages')||'0');

  if(!Object.prototype.hasOwnProperty.call(pageLabels,String(pages))){
    pages=0;
  }

  let activeAddons=[];

  try{
    const savedAddons=JSON.parse(localStorage.getItem('atelierAddons')||'[]');

    if(Array.isArray(savedAddons)){
      activeAddons=savedAddons.filter(function(key){
        return Object.prototype.hasOwnProperty.call(addonLabels,key);
      });
    }
  }catch(error){
    activeAddons=[];
  }

  const format=function(kes,selectedCurrency){
    if(selectedCurrency==='KES'){
      return 'KSh '+(Math.ceil(kes/500)*500).toLocaleString('en-US');
    }

    const rates=window.atelierData&&window.atelierData.rates
      ? window.atelierData.rates
      : {};

    const rate=Number(rates[selectedCurrency])||1;
    const step=roundSteps[selectedCurrency]||1;
    const value=Math.ceil((kes/rate)/step)*step;

    return symbols[selectedCurrency]+value.toLocaleString('en-US');
  };

  document.querySelectorAll('[data-estimator]').forEach(function(root){
    const result=root.querySelector('[data-estimate]');
    const projectTypeFields=document.querySelectorAll('select[name="project_type"]');

    const syncProjectTypeFields=function(){
      projectTypeFields.forEach(function(select){
        select.value=projectLabels[projectType];
      });
    };

    const update=function(){
      root.querySelectorAll('[data-currency]').forEach(function(button){
        button.classList.toggle(
          'active',
          button.dataset.currency===currency
        );
      });

      root.querySelectorAll('[data-type]').forEach(function(button){
        button.classList.toggle(
          'active',
          button.dataset.type===projectType
        );
      });

      root.querySelectorAll('[data-pages]').forEach(function(button){
        button.classList.toggle(
          'active',
          button.dataset.pages===String(pages)
        );
      });

      root.querySelectorAll('[data-addon]').forEach(function(button){
        button.classList.toggle(
          'active',
          activeAddons.includes(button.dataset.addonKey)
        );
      });

      const typeValue=projectTypes[projectType];

      if(typeValue===null){
        result.textContent='Scope review required';
      }else{
        let total=typeValue+pages;

        activeAddons.forEach(function(key){
          const button=root.querySelector(
            '[data-addon-key="'+key+'"]'
          );

          if(button){
            total+=Number(button.dataset.addon);
          }
        });

        result.textContent=
          format(total,currency)+
          ' – '+
          format(Math.round(total*1.25),currency);
      }

      document.querySelectorAll('[data-estimate-field]').forEach(function(field){
        field.value=result.textContent;
      });

      document.querySelectorAll('select[name="currency"]').forEach(function(select){
        select.value=currency;
      });

      document.querySelectorAll('[data-page-range-field]').forEach(function(field){
        field.value=projectType==='mobile'
          ? 'Not applicable'
          : pageLabels[String(pages)];
      });

      const selectedAddonLabels=activeAddons
        .map(function(key){
          return addonLabels[key];
        })
        .filter(Boolean);

      document.querySelectorAll('[data-addons-field]').forEach(function(field){
        field.value=selectedAddonLabels.length
          ? selectedAddonLabels.join(', ')
          : 'None';
      });
    };

    root.querySelectorAll('[data-currency]').forEach(function(button){
      button.addEventListener('click',function(){
        currency=button.dataset.currency;
        localStorage.setItem('atelierCurrency',currency);
        update();
      });
    });

    root.querySelectorAll('[data-type]').forEach(function(button){
      button.addEventListener('click',function(){
        projectType=button.dataset.type;
        localStorage.setItem('atelierProjectType',projectType);
        syncProjectTypeFields();
        update();
      });
    });

    root.querySelectorAll('[data-pages]').forEach(function(button){
      button.addEventListener('click',function(){
        pages=Number(button.dataset.pages);
        localStorage.setItem('atelierPages',String(pages));
        update();
      });
    });

    root.querySelectorAll('[data-addon]').forEach(function(button){
      button.addEventListener('click',function(){
        const key=button.dataset.addonKey;

        if(activeAddons.includes(key)){
          activeAddons=activeAddons.filter(function(item){
            return item!==key;
          });
        }else{
          activeAddons.push(key);
        }

        localStorage.setItem(
          'atelierAddons',
          JSON.stringify(activeAddons)
        );

        update();
      });
    });

    document.querySelectorAll('select[name="currency"]').forEach(function(select){
      select.value=currency;

      select.addEventListener('change',function(){
        currency=select.value;
        localStorage.setItem('atelierCurrency',currency);
        update();
      });
    });

    projectTypeFields.forEach(function(select){
      select.addEventListener('change',function(){
        const matchingType=Object.keys(projectLabels).find(function(key){
          return projectLabels[key]===select.value;
        });

        if(matchingType){
          projectType=matchingType;
          localStorage.setItem('atelierProjectType',projectType);
          update();
        }
      });
    });

    syncProjectTypeFields();
    update();
  });

    const projectForm=document.querySelector(
    '[data-project-form]'
  );

  if(projectForm){
    const submitButton=projectForm.querySelector(
      '[data-project-submit]'
    );

    const originalSubmitText=submitButton
      ? submitButton.textContent
      : '';

    const resetSubmitButton=function(){
      if(!submitButton){
        return;
      }

      submitButton.disabled=false;
      submitButton.removeAttribute('aria-busy');
      submitButton.textContent=originalSubmitText;
    };

    projectForm.addEventListener('submit',function(){
      if(!projectForm.checkValidity()||!submitButton){
        return;
      }

      submitButton.disabled=true;
      submitButton.setAttribute('aria-busy','true');
      submitButton.textContent='Sending your brief...';
    });

    window.addEventListener(
      'pageshow',
      resetSubmitButton
    );
  }
  
  const inquiryModalBackdrop=document.querySelector(
    '[data-inquiry-modal]'
  );

  if(inquiryModalBackdrop){
    const inquiryModal=inquiryModalBackdrop.querySelector(
      '.inquiry-modal'
    );

    const closeControls=inquiryModalBackdrop.querySelectorAll(
      '[data-inquiry-close]'
    );

    const focusableControls=inquiryModalBackdrop.querySelectorAll(
      'a[href],button:not([disabled])'
    );

    const closeInquiryModal=function(){
      inquiryModalBackdrop.classList.add('is-closing');
      document.body.classList.remove('inquiry-modal-open');

      const cleanUrl=new URL(window.location.href);
      cleanUrl.searchParams.delete('inquiry');

      window.history.replaceState(
        {},
        document.title,
        cleanUrl.toString()
      );

      window.setTimeout(function(){
        inquiryModalBackdrop.remove();
      },180);
    };

    document.body.classList.add('inquiry-modal-open');

    window.requestAnimationFrame(function(){
      inquiryModal.focus();
    });

    closeControls.forEach(function(control){
      control.addEventListener('click',function(event){
        event.preventDefault();
        closeInquiryModal();
      });
    });

    inquiryModalBackdrop.addEventListener('click',function(event){
      if(event.target===inquiryModalBackdrop){
        closeInquiryModal();
      }
    });

    document.addEventListener('keydown',function(event){
      if(event.key==='Escape'){
        closeInquiryModal();
      }

      if(
        event.key==='Tab' &&
        focusableControls.length>0
      ){
        const firstControl=focusableControls[0];
        const lastControl=
          focusableControls[focusableControls.length-1];

        if(
          event.shiftKey &&
          document.activeElement===firstControl
        ){
          event.preventDefault();
          lastControl.focus();
        }else if(
          !event.shiftKey &&
          document.activeElement===lastControl
        ){
          event.preventDefault();
          firstControl.focus();
        }
      }
    });
  }

  
})();