/**
 * API Service Layer
 * Handles all communication with the Laravel backend
 * Base URL: http://localhost:8000/api
 */

const API_BASE_URL = 'http://localhost:8000/api';

// Helper function to get auth token
function getAuthToken(): string | null {
  return localStorage.getItem('auth_token');
}

// Helper function to make API requests
export async function apiRequest<T>(
  endpoint: string,
  options: RequestInit = {}
): Promise<T> {
  const url = `${API_BASE_URL}${endpoint}`;
  const token = getAuthToken();

  const headers: Record<string, string> = {
    'Content-Type': 'application/json',
  };

  if (options.headers instanceof Headers) {
    options.headers.forEach((value, key) => {
      headers[key] = value;
    });
  } else if (typeof options.headers === 'object' && options.headers !== null) {
    Object.assign(headers, options.headers);
  }

  if (token) {
    headers['Authorization'] = `Bearer ${token}`;
  }

  const response = await fetch(url, {
    ...options,
    headers,
  });

  if (!response.ok) {
    const error = await response.json();
    throw new Error(error.message || `API Error: ${response.statusText}`);
  }

  return response.json();
}

// ==================== USER ENDPOINTS ====================

export const userAPI = {
  login: (email: string, password: string) =>
    apiRequest('/users/login', {
      method: 'POST',
      body: JSON.stringify({ email, password }),
    }),

  register: (name: string, prenom: string, email: string, password: string, role: string) =>
    apiRequest('/users/register', {
      method: 'POST',
      body: JSON.stringify({ name, prenom, email, password, role }),
    }),
};

// ==================== STUDENT ENDPOINTS ====================

export const studentAPI = {
  getAll: () =>
    apiRequest('/etudiants', {
      method: 'GET',
    }),

  getById: (id: string) =>
    apiRequest(`/etudiants/${id}`, {
      method: 'GET',
    }),

  create: (data: {
    name: string;
    prenom: string;
    email: string;
    apogee: string;
    filiere_id: string;
  }) =>
    apiRequest('/etudiants/add', {
      method: 'POST',
      body: JSON.stringify(data),
    }),

  update: (id: string, data: any) =>
    apiRequest(`/etudiants/${id}`, {
      method: 'PUT',
      body: JSON.stringify(data),
    }),

  delete: (id: string) =>
    apiRequest(`/etudiants/${id}`, {
      method: 'DELETE',
    }),

  getByFiliere: (filiereId: string) =>
    apiRequest(`/etudiants/filiere/${filiereId}`, {
      method: 'GET',
    }),
};

// ==================== TEACHER ENDPOINTS ====================

export const teacherAPI = {
  getAll: () =>
    apiRequest('/enseignants', {
      method: 'GET',
    }),

  getById: (id: string) =>
    apiRequest(`/enseignants/${id}`, {
      method: 'GET',
    }),

  create: (data: any) =>
    apiRequest('/enseignants/add', {
      method: 'POST',
      body: JSON.stringify(data),
    }),

  update: (id: string, data: any) =>
    apiRequest(`/enseignants/${id}`, {
      method: 'PUT',
      body: JSON.stringify(data),
    }),

  delete: (id: string) =>
    apiRequest(`/enseignants/${id}`, {
      method: 'DELETE',
    }),

  getByDepartement: (departementId: string) =>
    apiRequest(`/enseignants/departement/${departementId}`, {
      method: 'GET',
    }),
};

// ==================== FILIERE ENDPOINTS ====================

export const filiereAPI = {
  getAll: () =>
    apiRequest('/filieres', {
      method: 'GET',
    }),

  getById: (id: string) =>
    apiRequest(`/filieres/${id}`, {
      method: 'GET',
    }),

  create: (data: any) =>
    apiRequest('/filieres/add', {
      method: 'POST',
      body: JSON.stringify(data),
    }),

  update: (id: string, data: any) =>
    apiRequest(`/filieres/${id}`, {
      method: 'PUT',
      body: JSON.stringify(data),
    }),

  delete: (id: string) =>
    apiRequest(`/filieres/${id}`, {
      method: 'DELETE',
    }),

  getByDepartement: (departementId: string) =>
    apiRequest(`/filieres/departement/${departementId}`, {
      method: 'GET',
    }),
};

// ==================== MODULE ENDPOINTS ====================

export const moduleAPI = {
  getAll: () =>
    apiRequest('/modules', {
      method: 'GET',
    }).then((response: any) => response.data || response),

  getById: (id: string) =>
    apiRequest(`/modules/${id}`, {
      method: 'GET',
    }).then((response: any) => response.data || response),

  create: (data: any) =>
    apiRequest('/modules/add', {
      method: 'POST',
      body: JSON.stringify(data),
    }).then((response: any) => response.data || response),

  update: (id: string, data: any) =>
    apiRequest(`/modules/${id}`, {
      method: 'PUT',
      body: JSON.stringify(data),
    }).then((response: any) => response.data || response),

  delete: (id: string) =>
    apiRequest(`/modules/${id}`, {
      method: 'DELETE',
    }),

  getByEnseignant: (enseignantId: string) =>
    apiRequest(`/modules/enseignant/${enseignantId}`, {
      method: 'GET',
    }).then((response: any) => response.data || response),

  getByFiliere: (filiereId: string) =>
    apiRequest(`/modules/filiere/${filiereId}`, {
      method: 'GET',
    }).then((response: any) => response.data || response),
};

// ==================== SEANCE ENDPOINTS ====================

export const seanceAPI = {
  getAll: () =>
    apiRequest('/seances', {
      method: 'GET',
    }),

  getById: (id: string) =>
    apiRequest(`/seances/${id}`, {
      method: 'GET',
    }),

  create: (data: any) =>
    apiRequest('/seances/add', {
      method: 'POST',
      body: JSON.stringify(data),
    }),

  update: (id: string, data: any) =>
    apiRequest(`/seances/${id}`, {
      method: 'PUT',
      body: JSON.stringify(data),
    }),

  delete: (id: string) =>
    apiRequest(`/seances/${id}`, {
      method: 'DELETE',
    }),

  getByModule: (moduleId: string) =>
    apiRequest(`/seances/module/${moduleId}`, {
      method: 'GET',
    }),
};

// ==================== PRESENCE ENDPOINTS ====================

export const presenceAPI = {
  getAll: () =>
    apiRequest('/presences', {
      method: 'GET',
    }),

  getById: (id: string) =>
    apiRequest(`/presences/${id}`, {
      method: 'GET',
    }),

  markPresence: (data: any) =>
    apiRequest('/presences/marquer', {
      method: 'POST',
      body: JSON.stringify(data),
    }),

  update: (id: string, data: any) =>
    apiRequest(`/presences/${id}`, {
      method: 'PUT',
      body: JSON.stringify(data),
    }),

  delete: (id: string) =>
    apiRequest(`/presences/${id}`, {
      method: 'DELETE',
    }),

  getBySeance: (seanceId: string) =>
    apiRequest(`/presences/seance/${seanceId}`, {
      method: 'GET',
    }),

  getByEtudiant: (etudiantId: string) =>
    apiRequest(`/presences/etudiant/${etudiantId}`, {
      method: 'GET',
    }),
};

// ==================== ANNONCE ENDPOINTS ====================
export const annonceAPI = {
  // Récupérer toutes les annonces
  getAll: () =>
    apiRequest('/annonces', {  // ✅ Sans /api
      method: 'GET',
    }),

  // Récupérer une annonce par son ID
  getById: (id: string) =>
    apiRequest(`/annonces/${id}`, {  // ✅ Sans /api
      method: 'GET',
    }),

  // Créer une nouvelle annonce
  create: async (data: any) => {
    try {
      const formattedData = {
        ...data,
        datepublication: data.datepublication || new Date().toISOString().split('T')[0],
        enseignant_id: parseInt(data.enseignant_id) || data.enseignant_id,
      };

      console.log('📤 Envoi des données:', formattedData);

      const response = await apiRequest('/annonces/add', {  // ✅ Sans /api
        method: 'POST',
        body: JSON.stringify(formattedData),
      });

      console.log('✅ Réponse reçue:', response);
      return response;

    } catch (error) {
      console.error('❌ Erreur lors de la création:', error);
      throw error;
    }
  },

  // Mettre à jour une annonce
  update: (id: string, data: any) =>
    apiRequest(`/annonces/${id}`, {  // ✅ Sans /api
      method: 'PUT',
      body: JSON.stringify(data),
    }),

  // Supprimer une annonce
  delete: (id: string) =>
    apiRequest(`/annonces/${id}`, {  // ✅ Sans /api
      method: 'DELETE',
    }),

  // Récupérer toutes les annonces d'un enseignant spécifique
  getByEnseignant: (enseignantId: string) =>
    apiRequest(`/annonces/enseignant/${enseignantId}`, {  // ✅ Sans /api
      method: 'GET',
    }),

  // Récupérer les annonces pour un étudiant
  getForStudent: (etudiantId: string) =>
    apiRequest(`/annonces/student/${etudiantId}`, {  // ✅ Sans /api
      method: 'GET',
    }),
};
// ==================== DEPARTEMENT ENDPOINTS ====================

export const departementAPI = {
  getAll: () =>
    apiRequest('/departements', {
      method: 'GET',
    }),

  getById: (id: string) =>
    apiRequest(`/departements/${id}`, {
      method: 'GET',
    }),

  create: (data: any) =>
    apiRequest('/departements/add', {
      method: 'POST',
      body: JSON.stringify(data),
    }),

  update: (id: string, data: any) =>
    apiRequest(`/departements/${id}`, {
      method: 'PUT',
      body: JSON.stringify(data),
    }),

  delete: (id: string) =>
    apiRequest(`/departements/${id}`, {
      method: 'DELETE',
    }),
};

// ==================== DOCUMENT ENDPOINTS ====================

export const documentsAPI = {
  getAll: () =>
    apiRequest('/documents', {
      method: 'GET',
    }),

  getById: (id: string) =>
    apiRequest(`/documents/${id}`, {
      method: 'GET',
    }),

  upload: (formData: FormData) =>
    apiRequest('/documents/upload', {
      method: 'POST',
      body: formData,
    }),

  delete: (id: string) =>
    apiRequest(`/documents/${id}`, {
      method: 'DELETE',
    }),

  getByTeacher: (teacherId: string) =>
    apiRequest(`/documents/teacher/${teacherId}`, {
      method: 'GET',
    }),
};
