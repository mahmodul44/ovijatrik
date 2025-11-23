import { createI18n } from 'vue-i18n'

const messages = {
  en: {
    message: {
      home: 'Home',
      about: 'About',
      contact: 'Contact',
      language: 'Language',
    }
  },
  bn: {
    message: {
      home: 'হোম',
      about: 'সম্পর্কে',
      contact: 'যোগাযোগ',
      language: 'ভাষা',
    }
  }
}

const i18n = createI18n({
  locale: 'en',
  fallbackLocale: 'en',
  messages,
})

export default i18n
