'use strict';

document.addEventListener('DOMContentLoaded', () => {

  const navbarBurger = document.getElementById('navigation-burger');

  navbarBurger.addEventListener('click', () => {
    toggleMobileMenu(navbarBurger);
  });

  function toggleMobileMenu(el) {
    let target = el.dataset.target;
    let $target = document.getElementById(target);
    el.classList.toggle('is-active');
    $target.classList.toggle('is-active');
    if (el.classList.contains('is-active')) {
      el.setAttribute('aria-expanded', 'true');
    } else {
      el.setAttribute('aria-expanded', 'false');
    }
  }

  // Panel Tabs
  const $panelTabs = [...document.querySelectorAll('.panel-tabs a')];

  if ($panelTabs.length > 0) {
    $panelTabs.forEach((tab) => {
      tab.addEventListener('click', (e) => {
        let selected = tab.getAttribute('data-tab');
        let parent = tab.closest('.panel');
        !!parent.querySelectorAll('.panel-tabs a').
            forEach(n => n.classList.remove('is-active'));
        tab.classList.add('is-active');
        !!parent.querySelectorAll('.tabs-content').forEach(n => {
          n.classList.add('is-hidden');
          let data = n.getAttribute('data-content');
          if (data === selected) {
            n.classList.remove('is-hidden');
          }
        });
      });
    });
  }

});
