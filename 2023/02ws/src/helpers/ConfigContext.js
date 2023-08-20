import { createContext, useState, useContext } from 'react';

export const ConfigContext = createContext();
export const ConfigProvider = ({ children }) => {
    const [Configs, setConfigs] = useState(null)
  
  
    return (
      <ConfigContext.Provider value={{Configs,setConfigs}}>
        {children}
      </ConfigContext.Provider>
    )
  }
  
  export default ConfigProvider;