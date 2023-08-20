import { createContext, useState, useContext } from 'react';

export const CurrentUserContext = createContext();
export const CurrentUserProvider = ({ children }) => {
    const [currentUser, setCurrentUser] = useState(null)
  
    const fetchCurrentUser = async () => {
      let response = await fetch("/api/users/current")
      response = await response.json()
      setCurrentUser(response)
    }
  
    return (
      <CurrentUserContext.Provider value={{ currentUser, fetchCurrentUser }}>
        {children}
      </CurrentUserContext.Provider>
    )
  }
  
  export const useCurrentUser = () => useContext(CurrentUserContext)