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
         wind: "wind",
         dew: "dew",
         rain: "rain",
         radiation: "radiation",
         uv: "uv",
         pm10: "pm10",
         pm25: "pm25",
         pressure: "pressure",
         it_feels: "it feels"
      
        }
      },
      he: {
        translation: {
         welcome: "ברוכים הבאים ל",
         site: "ירושמיים",
         temp: "טמפרטורה",
         humidity: "לחות",
         wind: "רוח",
         dew: "נקודת טל",
         rain: "גשם",
         radiation: "קרינה",
         uv: "uv",
         pm10: "אבק גדול",
         pm25: "אבק קטן",
         pressure: "לחץ אוויר",
         it_feels: "מרגיש כמו"

        }
      },
    }
  });

export default i18n;