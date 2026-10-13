const mobileMenuBtn = document.querySelector('#mobile-menu');
const closeMenuBtn = document.querySelector('#close-menu');
const sidebar = document.querySelector('.sidebar');

if (mobileMenuBtn) {
  mobileMenuBtn.addEventListener('click', () => {
    sidebar.classList.add('show');
  });
}

if (closeMenuBtn) {
  closeMenuBtn.addEventListener('click', () => {
    sidebar.classList.add('hide');
    setTimeout(() => {
      sidebar.classList.remove('show');
      sidebar.classList.remove('hide');
    }, 600);
  });
}


window.addEventListener('resize', () => {
  const screenWidth = document.body.clientWidth;
  if (screenWidth >= 768) {
    sidebar.classList.remove('show');
  }
});