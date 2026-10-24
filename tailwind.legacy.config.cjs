/**
 * Design tokens of the previous site (Tailwind 2/3 config), loaded by
 * Tailwind 4 through `@config` in resources/css/app.css so the ported
 * views keep their utility classes (mobile:, tablet:, text_blue, pb-13...).
 */
module.exports = {
  content: [
    './resources/views/**/*.blade.php',
    './app/Livewire/**/*.php',
    './app/View/**/*.php',
  ],
  theme: {
    letterSpacing: {
      tightest: '-.075em',
      tighter: '-.05em',
      tight: '-.025em',
      normal: '0',
      wide: '1.5px',
      wider: '.05em',
      wider_lg: '.1em',
      widest: '.15em',
    },
    extend: {
      fontFamily: {
        body: ['"Red Hat Display"'],
        primary: ['"Noto Sans"'],
        secondary: ['"Montserrat"'],
        Helvetica_Bold: ['"Helvetica-Bold"']
      },
      borderRadius: {
        'btn': '31px',
        '10p': '10px'
      },
      spacing: {
        '5p': '5px',
        '10p': '10px',
        '14p': '14px',
        '15p': '15px',
        '16p': '16px',
        '48p': '48%',
        '52p': '52%',
        '15_2': '60px',
        '16_1': '52px',
        '30': '120px',
        '50p': '50px',
        '25p': '25px',
        '18': '4.375rem'
      },
      padding: {
        '13': '52px',
        '15': '3.93rem',
        '15_2': '60px',
        '22': '5.625rem',
        '26': '6.6875rem',
        '5p': '5px'
      },
      margin: {
        '13': '3.25rem',
        '18': '4.375rem',
        '46': '11.44rem'
      },
      maxWidth: {
        '1.5xl': '40rem',
        '3.5xl': '51.5rem',
        '4.5xl': '62.5rem',
        'thumb': '11.375rem',
        'discription': '248px'
      },
      fontSize: {
        '10p': '0.625rem',
        '50p': '3.125rem',
        '40p': '2.5rem',
        '8.5xl': ['7.5rem', '7.8rem'],
        '80p': ['80px', '90px'],
      },
      colors: {
        primary: '#6E6E6E',
        secondary: '#ededed',
        body_bg: '#ffffff',
        body_text: '#4a4349',
        title: '#3fb2cf',
        grey: '#524A51',
        dark_grey: '#4a4349',
        light_grey: '#B7B7B7',
        medium_grey: '#575156',
        lightten_grey: '#C6C6C6',
        grey_300: '#d3d3d3',
        grey_400: '#b7b7b7',
        blue: '#5ba4dc',
        medium_blue: '#45cdfc',
        dark_blue: '#0080ac',
        text_blue: '#3FB2CF',
        footer_bg: '#464646',
        brown: '#805300',
        dark_brown: '#874433',
        pink: '#850737',
        yellow: '#ed9143',
        purple: '#6847c3',
        green: '#7bbc00',
        dark_green: '#479b51',
        medium_green: '#3aac2b',
        light_green: '#9acb3e',
        dark_border: '#707070'
      }
    },
    screens: {
      'sm': '600px',

      'md': '768px',

      'lg': '992px',

      'xl': '1280px',

      '2xl': '1536px',

      'desktop_extralarge': { 'max': '1550px' },

      'desktop_large': { 'max': '1240px' },

      'desktop_medium': { 'max': '1200px' },

      'desktop': { 'max': '1024px' },

      'tablet': { 'max': '991.9px' },

      'mobile': { 'max': '767.9px' },

      'mobile-small': { 'max': '479px' }
    },

  },
  plugins: [],
};
