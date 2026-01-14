import React, { createContext, useContext, useState, useEffect } from 'react';

export type UserRole = 'admin' | 'enseignant' | 'etudiant';

export interface User {
  id: string;
  name: string;
  prenom: string;
  email: string;
  role: UserRole;
}

interface AuthContextType {
  user: User | null;
  token: string | null;
  isAuthenticated: boolean;
  login: (token: string, user: User) => void;
  logout: () => void;
  isLoading: boolean;
}

const AuthContext = createContext<AuthContextType | undefined>(undefined);

export function AuthProvider({ children }: { children: React.ReactNode }) {
  const [user, setUser] = useState<User | null>(null);
  const [token, setToken] = useState<string | null>(null);
  const [isLoading, setIsLoading] = useState(true);

  // Load auth state from localStorage on mount
  useEffect(() => {
    const storedToken = localStorage.getItem('auth_token');
    const storedUser = localStorage.getItem('user_id');

    if (storedToken && storedUser) {
      setToken(storedToken);
      setUser({
        id: storedUser,
        name: localStorage.getItem('user_name') || '',
        prenom: localStorage.getItem('user_prenom') || '',
        email: localStorage.getItem('user_email') || '',
        role: (localStorage.getItem('user_role') as UserRole) || 'etudiant',
      });
    }

    setIsLoading(false);
  }, []);

  const login = (newToken: string, newUser: User) => {
    setToken(newToken);
    setUser(newUser);
    localStorage.setItem('auth_token', newToken);
    localStorage.setItem('user_id', newUser.id);
    localStorage.setItem('user_name', newUser.name);
    localStorage.setItem('user_prenom', newUser.prenom);
    localStorage.setItem('user_email', newUser.email);
    localStorage.setItem('user_role', newUser.role);
  };

  const logout = () => {
    setToken(null);
    setUser(null);
    localStorage.removeItem('auth_token');
    localStorage.removeItem('user_id');
    localStorage.removeItem('user_name');
    localStorage.removeItem('user_prenom');
    localStorage.removeItem('user_email');
    localStorage.removeItem('user_role');
  };

  return (
    <AuthContext.Provider value={{ user, token, isAuthenticated: !!token, login, logout, isLoading }}>
      {children}
    </AuthContext.Provider>
  );
}

export function useAuth() {
  const context = useContext(AuthContext);
  if (!context) {
    throw new Error('useAuth must be used within an AuthProvider');
  }
  return context;
}
