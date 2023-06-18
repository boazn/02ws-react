import i18n from 'i18next';
import { initReactI18next } from 'react-i18next';

i18n
  .use(initReactI18next)
  .init({
    debug: true,
    fallbackLng: 'he',
    interpolation: {
      escapeValue: false, // not needed for react as it escapes by default
    },
    // language resources
    resources: {
      en: {
        translation: {
         welcome: "Welcome to",
         site: "02ws",
         temp: "Temp",
         humidity: "Humidity",
         wind: "wind"

      
        }
      },
      he: {
        translation: {
         welcome: "ברוכים הבאים ל",
         site: "ירושמיים",
         temp: "טמפרטורה",
         humidity: "לחות",
         wind: "רוח"

        }
      },
    }
  });

export default i18n;