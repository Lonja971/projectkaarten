<div class="mb-ch-80">
   <style>
      ul {
         padding-left: 30px;
      }
      .mb-ch-80 > *:not(:last-child){
         margin-bottom: 80px;
      }
      .mb-ch-50 > *:not(:last-child){
         margin-bottom: 50px;
      }
      .mb-ch-10 > *:not(:last-child){
         margin-bottom: 10px;
      }
   </style>

   <div>
      <h1>API Help</h1>
      <p>Base URL: <code>http://127.0.0.1:8000</code></p>
   </div>
   <div>
      <h3 class="text-xl">Users</h3>
      <div class="mb-ch-50">
         <div class="endpoint mb-ch-10">
            <div>
               <h2><span class="font-bold">GET</span> | <span class="italic">/users</span> *ALLEEN VOOR DOCENTEN</h2>
               <p>Een lijst van alle gebruikers ophalen.</p>
            </div>
            <h4>Parameters:</h4>
            <ul class="list-disc">
                <li><code>api_key (str)</code> - API-gebruikerssleutel *REQUIRED</li>
                <li><code>page (int)</code> - paginering (standaard wordt 1 gebruikt)</li>
            </ul>
            <h4>Returns:</h4>
            <div x-data="{ open: false }" class="mb-4">
               <button @click="open = !open" class="bg-blue-600 text-white px-4 py-2 rounded-md">
                  JSON-structuur weergeven
               </button>
               <div x-show="open" class="mt-4 bg-gray-100 p-4 rounded-md">
                  <ul class="list-disc">
                     <li>current_page</li>
                     <li>
                        data
                        <ul class="list-disc">
                           <li>id</li>
                           <li>full_name</li>
                           <li>identifier</li>
                           <li>role_id</li>
                           <li>email</li>
                           <li>email_verified_at</li>
                           <li>project_index</li>
                           <li>created_at</li>
                           <li>updated_at</li>
                        </ul>
                        ...
                     </li>
                     <li>first_page_url - int</li>
                     <li>from</li>
                     <li>last_page</li>
                     <li>last_page_url</li>
                     <li>
                        links
                        <ul class="list-disc">
                           <li>url</li>
                           <li>label</li>
                           <li>active</li>
                        </ul>
                        ...
                     </li>
                     <li>next_page_url</li>
                     <li>path</li>
                     <li>per_page</li>
                     <li>prev_page_url</li>
                     <li>to</li>
                     <li>total</li>
                  </ul>      
               </div>
            </div>
         </div>
         <div class="endpoint mb-ch-10">
            <div>
               <h2><span class="font-bold">POST</span> | <span class="italic">/users</span> *ALLEEN VOOR DOCENTEN</h2>
               <p>De nieuwe gebruiker opslaan.</p>
            </div>
            <h4>Parameters:</h4>
            <ul class="list-disc">
                <li><code>api_key (str)</code> - API-gebruikerssleutel *REQUIRED</li>
                <li><code>full_name (str)</code> - Volledige naam van de gebruiker *REQUIRED</li>
                <li><code>identifier (str)</code> - Eigen nummer voor de gebruiker *REQUIRED</li>
                <li><code>role_id (int)</code> - Rolnummer id *REQUIRED</li>
                <li><code>email (str)</code> - Email *REQUIRED</li>
            </ul>
            <h4>Returns:</h4>
            <div x-data="{ open: false }" class="mb-4">
               <button @click="open = !open" class="bg-blue-600 text-white px-4 py-2 rounded-md">
                  JSON-structuur weergeven
               </button>
               <div x-show="open" class="mt-4 bg-gray-100 p-4 rounded-md">
                  <ul class="list-disc">
                     <li>status</li>
                     <li>message</li>
                     <li>
                        data
                        <ul>
                           <li>id</li>
                           <li>full_name</li>
                           <li>identifier</li>
                           <li>role_id</li>
                           <li>email</li>
                           <li>created_at</li>
                           <li>api_key</li>
                        </ul>
                     </li>
                  </ul>      
               </div>
            </div>
         </div>
         <div class="endpoint mb-ch-10">
            <div>
               <h2><span class="font-bold">GET</span> | <span class="italic">/users/{user_id}</span> *ALLEEN VOOR DOCENTEN</h2>
               <p>Gebruikersinformatie ophalen.</p>
            </div>
            <h4>Parameters:</h4>
            <ul class="list-disc">
                <li><code>api_key (str)</code> - API-gebruikerssleutel *REQUIRED</li>
            </ul>
            <h4>Returns:</h4>
            <div x-data="{ open: false }" class="mb-4">
               <button @click="open = !open" class="bg-blue-600 text-white px-4 py-2 rounded-md">
                  JSON-structuur weergeven
               </button>
               <div x-show="open" class="mt-4 bg-gray-100 p-4 rounded-md">
                  <ul class="list-disc">
                     <li>status</li>
                     <li>message</li>
                     <li>
                        data
                        <ul>
                           <li>id</li>
                           <li>full_name</li>
                           <li>identifier</li>
                           <li>role_id</li>
                           <li>email</li>
                           <li>created_at</li>
                        </ul>
                     </li>
                  </ul>      
               </div>
            </div>
         </div>
         <div class="endpoint mb-ch-10">
            <div>
               <h2><span class="font-bold">PUT</span> | <span class="italic">/users/{user_id}</span> *ALLEEN VOOR DOCENTEN</h2>
               <p>Gebruikersinformatie wijzigen.</p>
            </div>
            <h4>Parameters:</h4>
            <ul class="list-disc">
                <li><code>api_key (str)</code> - API-gebruikerssleutel *REQUIRED</li>
                <li><code>full_name (str)</code> - Volledige naam van de gebruiker</li>
                <li><code>email (str)</code> - Email</li>
                <li><code>password (str)</code> - New password</li>
                <li><code>identifier (str)</code> - Eigen gebruikersnummer</li>
            </ul>
            <h4>Returns:</h4>
            <div x-data="{ open: false }" class="mb-4">
               <button @click="open = !open" class="bg-blue-600 text-white px-4 py-2 rounded-md">
                  JSON-structuur weergeven
               </button>
               <div x-show="open" class="mt-4 bg-gray-100 p-4 rounded-md">
                  <ul class="list-disc">
                     <li>status</li>
                     <li>message</li>
                     <li>
                        data
                        <ul>
                           <li>id</li>
                           <li>full_name</li>
                           <li>identifier</li>
                           <li>role_id</li>
                           <li>email</li>
                           <li>created_at</li>
                        </ul>
                     </li>
                  </ul>      
               </div>
            </div>
         </div>
         <div class="endpoint mb-ch-10">
            <div>
               <h2><span class="font-bold">DELETE</span> | <span class="italic">/users/{user_id}</span> *ALLEEN VOOR DOCENTEN</h2>
               <p>De gebruiker verwijderen.</p>
            </div>
            <h4>Parameters:</h4>
            <ul class="list-disc">
                <li><code>api_key (str)</code> - API-gebruikerssleutel *REQUIRED</li>
            </ul>
            <h4>Returns:</h4>
            <div x-data="{ open: false }" class="mb-4">
               <button @click="open = !open" class="bg-blue-600 text-white px-4 py-2 rounded-md">
                  JSON-structuur weergeven
               </button>
               <div x-show="open" class="mt-4 bg-gray-100 p-4 rounded-md">
                  <ul class="list-disc">
                     <li>status</li>
                     <li>message</li>
                  </ul>      
               </div>
            </div>
         </div>
         <div class="endpoint mb-ch-10">
            <div>
               <h2><span class="font-bold">GET</span> | <span class="italic">/users/search</span> *ALLEEN VOOR DOCENTEN</h2>
               <p>Verkrijg de gebruikersnaam van de informatiezoeker.</p>
            </div>
            <h4>Parameters:</h4>
            <ul class="list-disc">
                <li><code>api_key (str)</code> - API-gebruikerssleutel *REQUIRED</li>
                <li><code>column (str)</code> -In welke kolom zoeken we (bijvoorbeeld full_name)</li>
                <li><code>value (str)</code> - Volledige naam van de gebruiker</li>
            </ul>
            <h4>Returns:</h4>
            <div x-data="{ open: false }" class="mb-4">
               <button @click="open = !open" class="bg-blue-600 text-white px-4 py-2 rounded-md">
                  JSON-structuur weergeven
               </button>
               <div x-show="open" class="mt-4 bg-gray-100 p-4 rounded-md">
                  <ul class="list-disc">
                     <li>status</li>
                     <li>data
                        <ul>
                           <li>...</li>
                        </ul>
                     </li>
                  </ul>      
               </div>
            </div>
         </div>
      </div>
   </div>
   <div>
      <h3 class="text-xl">Projects</h3>
      <div class="mb-ch-50">
         <div class="endpoint mb-ch-10">
            <div>
               <h2><span class="font-bold">GET</span> | <span class="italic">/projects</span> *ALLEEN VOOR DOCENTEN</h2>
               <p>Een lijst van alle projecten ophalen.</p>
            </div>
            <h4>Parameters:</h4>
            <ul class="list-disc">
                <li><code>api_key (str)</code> - API-gebruikerssleutel *REQUIRED</li>
                <li><code>page (int)</code> - paginering (standaard wordt 1 gebruikt)</li>
            </ul>
            <h4>Returns:</h4>
            <div x-data="{ open: false }" class="mb-4">
               <button @click="open = !open" class="bg-blue-600 text-white px-4 py-2 rounded-md">
                  JSON-structuur weergeven
               </button>
               <div x-show="open" class="mt-4 bg-gray-100 p-4 rounded-md">
                  <ul class="list-disc">
                     <li>current_page</li>
                     <li>
                        data
                        <ul class="list-disc">
                           <li>id</li>
                           <li>user_id</li>
                           <li>title</li>
                           <li>date_start</li>
                           <li>date_end</li>
                           <li>reflection</li>
                           <li>rating</li>
                           <li>feedback</li>
                           <li>denial_reason</li>
                           <li>status_id</li>
                           <li>icon_id</li>
                           <li>background_id</li>
                           <li>project_by_student</li>
                           <li>created_at</li>
                           <li>updated_at</li>
                        </ul>
                        ...
                     </li>
                     <li>first_page_url - int</li>
                     <li>from</li>
                     <li>last_page</li>
                     <li>last_page_url</li>
                     <li>
                        links
                        <ul class="list-disc">
                           <li>url</li>
                           <li>label</li>
                           <li>active</li>
                        </ul>
                        ...
                     </li>
                     <li>next_page_url</li>
                     <li>path</li>
                     <li>per_page</li>
                     <li>prev_page_url</li>
                     <li>to</li>
                     <li>total</li>
                  </ul>      
               </div>
            </div>
         </div>
         <div class="endpoint mb-ch-10">
            <div>
               <h2><span class="font-bold">POST</span> | <span class="italic">/projects</span></h2>
               <p>De nieuwe project opslaan.</p>
            </div>
            <h4>Parameters:</h4>
            <ul class="list-disc">
                <li><code>api_key (str)</code> - API-gebruikerssleutel *REQUIRED</li>
                <li><code>user_id (int)</code> - Id van de gebruiker voor wie het project wordt aangemaakt. Verplichte parameter als de API-sleutel aan de docent toebehoort.</li>
                <li><code>title (str)</code> - Projecttitel *REQUIRED</li>
                <li><code>date_end (date)</code> - Datum voltooiing project *REQUIRED</li>
                <li><code>icon_id (int)</code> - Icoon id</li>
                <li><code>background_id (int)</code> - Achtergrond id</li>
            </ul>
            <h4>Returns:</h4>
            <div x-data="{ open: false }" class="mb-4">
               <button @click="open = !open" class="bg-blue-600 text-white px-4 py-2 rounded-md">
                  JSON-structuur weergeven
               </button>
               <div x-show="open" class="mt-4 bg-gray-100 p-4 rounded-md">
                  <ul class="list-disc">
                     <li>status</li>
                     <li>message</li>
                     <li>
                        data
                        <ul class="list-disc">
                           <li>id</li>
                           <li>user_id</li>
                           <li>title</li>
                           <li>date_start</li>
                           <li>date_end</li>
                           <li>reflection</li>
                           <li>rating</li>
                           <li>feedback</li>
                           <li>denial_reason</li>
                           <li>status
                              <ul>
                                 <li>id</li>
                                 <li>name</li>
                              </ul>
                           </li>
                           <li>icon_id</li>
                           <li>background_id</li>
                           <li>project_by_student</li>
                           <li>created_at</li>
                        </ul>
                     </li>
                  </ul>      
               </div>
            </div>
         </div>
         <div class="endpoint mb-ch-10">
            <div>
               <h2><span class="font-bold">GET</span> | <span class="italic">/projects/{project_id}</span></h2>
               <p>Projectinformatie ophalen.</p>
            </div>
            <h4>Parameters:</h4>
            <ul class="list-disc">
                <li><code>api_key (str)</code> - API-gebruikerssleutel *REQUIRED</li>
            </ul>
            <h4>Returns:</h4>
            <div x-data="{ open: false }" class="mb-4">
               <button @click="open = !open" class="bg-blue-600 text-white px-4 py-2 rounded-md">
                  JSON-structuur weergeven
               </button>
               <div x-show="open" class="mt-4 bg-gray-100 p-4 rounded-md">
                  <ul class="list-disc">
                     <li>status</li>
                     <li>
                        data
                        <ul class="list-disc">
                           <li>id</li>
                           <li>user_id</li>
                           <li>title</li>
                           <li>date_start</li>
                           <li>date_end</li>
                           <li>reflection</li>
                           <li>rating</li>
                           <li>feedback</li>
                           <li>denial_reason</li>
                           <li>status
                              <ul>
                                 <li>id</li>
                                 <li>name</li>
                              </ul>
                           </li>
                           <li>icon_id</li>
                           <li>background_id</li>
                           <li>project_by_student</li>
                           <li>created_at</li>
                           <li>sprints</li>
                        </ul>
                     </li>
                  </ul>      
               </div>
            </div>
         </div>
         <div class="endpoint mb-ch-10">
            <div>
               <h2><span class="font-bold">GET</span> | <span class="italic">/projects-by-user</span></h2>
               <p>Haal de projectlijst van de gebruiker op.</p>
            </div>
            <h4>Parameters:</h4>
            <ul class="list-disc">
                <li><code>api_key (str)</code> - API-gebruikerssleutel *REQUIRED</li>
                <li><code>user_id (int)</code> -  Id van de gebruiker Id van de gebruiker voor wie het project wordt aangemaakt. Verplichte parameter als de API-sleutel aan de docent toebehoort.</li>
                <li><code>page (int)</code> -paginering (standaard wordt 1 gebruikt)</li>
            </ul>
            <h4>Returns:</h4>
            <div x-data="{ open: false }" class="mb-4">
               <button @click="open = !open" class="bg-blue-600 text-white px-4 py-2 rounded-md">
                  JSON-structuur weergeven
               </button>
               <div x-show="open" class="mt-4 bg-gray-100 p-4 rounded-md">
                  <ul class="list-disc">
                     <li>current_page</li>
                     <li>
                        data
                        <ul class="list-disc">
                           <li>id</li>
                           <li>user_id</li>
                           <li>title</li>
                           <li>date_start</li>
                           <li>date_end</li>
                           <li>reflection</li>
                           <li>rating</li>
                           <li>feedback</li>
                           <li>denial_reason</li>
                           <li>status_id</li>
                           <li>icon_id</li>
                           <li>background_id</li>
                           <li>project_by_student</li>
                           <li>created_at</li>
                           <li>updated_at</li>
                        </ul>
                        ...
                     </li>
                     <li>first_page_url - int</li>
                     <li>from</li>
                     <li>last_page</li>
                     <li>last_page_url</li>
                     <li>
                        links
                        <ul class="list-disc">
                           <li>url</li>
                           <li>label</li>
                           <li>active</li>
                        </ul>
                        ...
                     </li>
                     <li>next_page_url</li>
                     <li>path</li>
                     <li>per_page</li>
                     <li>prev_page_url</li>
                     <li>to</li>
                     <li>total</li>
                  </ul>         
               </div>
            </div>
         </div>
         <div class="endpoint mb-ch-10">
            <div>
               <h2><span class="font-bold">DELETE</span> | <span class="italic">/projects/{project_id}</span></h2>
               <p>Projectinformatie verwijderen.</p>
            </div>
            <h4>Parameters:</h4>
            <ul class="list-disc">
                <li><code>api_key (str)</code> - API-gebruikerssleutel *REQUIRED</li>
            </ul>
            <h4>Returns:</h4>
            <div x-data="{ open: false }" class="mb-4">
               <button @click="open = !open" class="bg-blue-600 text-white px-4 py-2 rounded-md">
                  JSON-structuur weergeven
               </button>
               <div x-show="open" class="mt-4 bg-gray-100 p-4 rounded-md">
                  <ul class="list-disc">
                     <li>status</li>
                     <li>message</li>
                  </ul>      
               </div>
            </div>
         </div>
         <div class="endpoint mb-ch-10">
            <div>
               <h2><span class="font-bold">PUT</span> | <span class="italic">/projects/{project_id}</span></h2>
               <p>Projectinformatie wijzigen.</p>
            </div>
            <h4>Parameters:</h4>
            <ul class="list-disc">
                <li><code>api_key (str)</code> - API-gebruikerssleutel *REQUIRED</li>
                <li><code>title (str)</code> - Projecttitel</li>
                <li><code>icon_id (int)</code> - Icoon Id</li>
                <li><code>background_id (int)</code> - Achtergrond id</li>
                <li><code>reflection_id (str)</code> - Reflectie id</li>
                <li><code>rating (int)</code> - Rating</li>
                <li><code>feedback (str)</code> - Beoordeling</li>
                <li><code>denial_reason (str)</code> - Ontkenningsreden</li>
                <li><code>status_id (int)</code> - Project status id</li>
            </ul>
            <h4>Returns:</h4>
            <div x-data="{ open: false }" class="mb-4">
               <button @click="open = !open" class="bg-blue-600 text-white px-4 py-2 rounded-md">
                  JSON-structuur weergeven
               </button>
               <div x-show="open" class="mt-4 bg-gray-100 p-4 rounded-md">
                  <ul class="list-disc">
                     <li>status</li>
                     <li>message</li>
                     <li>
                        data
                        <ul class="list-disc">
                           <li>id</li>
                           <li>user_id</li>
                           <li>title</li>
                           <li>date_start</li>
                           <li>date_end</li>
                           <li>reflection</li>
                           <li>rating</li>
                           <li>feedback</li>
                           <li>denial_reason</li>
                           <li>status
                              <ul>
                                 <li>id</li>
                                 <li>name</li>
                              </ul>
                           </li>
                           <li>icon_id</li>
                           <li>background_id</li>
                           <li>project_by_student</li>
                           <li>created_at</li>
                           <li>sprints</li>
                        </ul>
                     </li>
                  </ul>      
               </div>
            </div>
         </div>
      </div>
   </div>
   <div>
      <h3 class="text-xl">Sprints</h3>
      <div class="mb-ch-50">
         <div class="endpoint mb-ch-10">
            <div>
               <h2><span class="font-bold">GET</span> | <span class="italic">/sprints</span> *ALLEEN VOOR DOCENTEN</h2>
               <p>Een lijst van alle sprints ophalen.</p>
            </div>
            <h4>Parameters:</h4>
            <ul class="list-disc">
                <li><code>api_key (str)</code> - API-gebruikerssleutel *REQUIRED</li>
                <li><code>page (int)</code> - paginering (standaard wordt 1 gebruikt)</li>
            </ul>
            <h4>Returns:</h4>
            <div x-data="{ open: false }" class="mb-4">
               <button @click="open = !open" class="bg-blue-600 text-white px-4 py-2 rounded-md">
                  JSON-structuur weergeven
               </button>
               <div x-show="open" class="mt-4 bg-gray-100 p-4 rounded-md">
                  <ul class="list-disc">
                     <li>current_page</li>
                     <li>
                        data
                        <ul class="list-disc">
                           <li>id</li>
                           <li>project_id</li>
                           <li>sprint_nr</li>
                           <li>date_start</li>
                           <li>date_end</li>
                           <li>reflection</li>
                           <li>feedback</li>
                           <li>status_id</li>
                           <li>created_at</li>
                           <li>updated_at</li>
                        </ul>
                        ...
                     </li>
                     <li>first_page_url - int</li>
                     <li>from</li>
                     <li>last_page</li>
                     <li>last_page_url</li>
                     <li>
                        links
                        <ul class="list-disc">
                           <li>url</li>
                           <li>label</li>
                           <li>active</li>
                        </ul>
                        ...
                     </li>
                     <li>next_page_url</li>
                     <li>path</li>
                     <li>per_page</li>
                     <li>prev_page_url</li>
                     <li>to</li>
                     <li>total</li>
                  </ul>      
               </div>
            </div>
         </div>
         <div class="endpoint mb-ch-10">
            <div>
               <h2><span class="font-bold">GET</span> | <span class="italic">/sprints/{sprint_id}</span></h2>
               <p>Sprintsinformatie ophalen.</p>
            </div>
            <h4>Parameters:</h4>
            <ul class="list-disc">
                <li><code>api_key (str)</code> - API-gebruikerssleutel *REQUIRED</li>
            </ul>
            <h4>Returns:</h4>
            <div x-data="{ open: false }" class="mb-4">
               <button @click="open = !open" class="bg-blue-600 text-white px-4 py-2 rounded-md">
                  JSON-structuur weergeven
               </button>
               <div x-show="open" class="mt-4 bg-gray-100 p-4 rounded-md">
                  <ul class="list-disc">
                     <li>status</li>
                     <li>message</li>
                     <li>
                        data
                        <ul class="list-disc">
                           <li>id</li>
                           <li>project_id</li>
                           <li>sprint_nr</li>
                           <li>reflection</li>
                           <li>feedback</li>
                           <li>
                              status
                              <ul class="list-disc">
                                 <li>id</li>
                                 <li>name</li>
                              </ul>
                           </li>
                           <li>
                              goals
                              <ul class="list-disc">
                                 <li>id</li>
                                 <li>description</li>
                                 <li>is_retrospective</li>
                                 <li>created_at</li>
                                 <li>
                                    workprocesses
                                    <ul class="list-disc">
                                       <li>id</li>
                                       <li>sprint_goal_id</li>
                                       <li>workprocess_id</li>
                                    </ul>
                                    ...
                                 </li>
                              </ul>
                              ...
                           </li>
                           <li>created_at</li>
                        </ul>
                     </li>
                  </ul>      
               </div>
            </div>
         </div>
         <div class="endpoint mb-ch-10">
            <div>
               <h2><span class="font-bold">GET</span> | <span class="italic">/sprints-by-project</span></h2>
               <p>Haal een sprintsheet voor het project.</p>
            </div>
            <h4>Parameters:</h4>
            <ul class="list-disc">
                <li><code>api_key (str)</code> - API-gebruikerssleutel *REQUIRED</li>
                <li><code>project_id (int)</code> - De parameter is vereist als je een api_key van een leraar hebt.</li>
                <li><code>page (int)</code> -paginering (standaard wordt 1 gebruikt)</li>
            </ul>
            <h4>Returns:</h4>
            <div x-data="{ open: false }" class="mb-4">
               <button @click="open = !open" class="bg-blue-600 text-white px-4 py-2 rounded-md">
                  JSON-structuur weergeven
               </button>
               <div x-show="open" class="mt-4 bg-gray-100 p-4 rounded-md">
                  <ul class="list-disc">
                     <li>current_page</li>
                     <li>
                        data
                        <ul class="list-disc">
                           <li>id</li>
                           <li>project_id</li>
                           <li>sprint_nr</li>
                           <li>date_start</li>
                           <li>date_end</li>
                           <li>reflection</li>
                           <li>feedback</li>
                           <li>status_id</li>
                           <li>created_at</li>
                           <li>updated_at</li>
                        </ul>
                        ...
                     </li>
                     <li>first_page_url - int</li>
                     <li>from</li>
                     <li>last_page</li>
                     <li>last_page_url</li>
                     <li>
                        links
                        <ul class="list-disc">
                           <li>url</li>
                           <li>label</li>
                           <li>active</li>
                        </ul>
                        ...
                     </li>
                     <li>next_page_url</li>
                     <li>path</li>
                     <li>per_page</li>
                     <li>prev_page_url</li>
                     <li>to</li>
                     <li>total</li>
                  </ul>       
               </div>
            </div>
         </div>
         <div class="endpoint mb-ch-10">
            <div>
               <h2><span class="font-bold">PUT</span> | <span class="italic">/sprints/{sprint_id}</span></h2>
               <p>Sprintsinformatie wijzigen.</p>
            </div>
            <h4>Parameters:</h4>
            <ul class="list-disc">
                <li><code>api_key (str)</code> - API-gebruikerssleutel *REQUIRED</li>
                <li><code>reflection (str)</code> - Reflectie id</li>
                <li><code>feedback (str)</code> - Beoordeling</li>
                <li>
                  <code>goals (object)</code>
                  <ul class="list-disc">
                     <li><code>create (array)</code>
                        <ul class="list-disc">
                           <li><code>description (str)</code> - Beschrijving van het doel *REQUIRED</li>
                           <li><code>is_retrospective (bool)</code> - Is het een retrospectief *REQUIRED</li>
                           <li>
                              <code>workprocesses_ids (array)</code> - Ids van werkprocesses
                              <br/>...
                           </li>
                        </ul>
                        ...
                     </li>
                     <li><code>update (array)</code>
                        <ul class="list-disc">
                           <li><code>id (int)</code> - Id van het doel *REQUIRED</li>
                           <li><code>description (str)</code> - Beschrijving van het doel</li>
                           <li><code>is_retrospective (bool)</code> - Is het een retrospectief</li>
                           <li>
                              <code>workprocesses (object)</code>
                              <ul class="list-disc">
                                 <li>
                                    <code>remove (array)</code> - Alle werkprocessen id verwijderen
                                    <br/>...
                                 </li>
                                 <li>
                                    <code>add (array)</code> - Alle werkprocessen id die moeten worden toegevoegd
                                    <br/>...
                                 </li>
                              </ul>
                           </li>
                        </ul>
                        ...
                     </li>
                     <li>
                        <code>delete (array)</code> - Alle doel-ID's die moeten worden verwijderd.
                        <br/>...
                     </li>
                  </ul>
                </li>
            </ul>
            <h4>Returns:</h4>
            <div x-data="{ open: false }" class="mb-4">
               <button @click="open = !open" class="bg-blue-600 text-white px-4 py-2 rounded-md">
                  JSON-structuur weergeven
               </button>
               <div x-show="open" class="mt-4 bg-gray-100 p-4 rounded-md">
                  <ul class="list-disc">
                     <li>status</li>
                     <li>message</li>
                     <li>
                        data
                        <ul class="list-disc">
                           <li>id</li>
                           <li>project_id</li>
                           <li>sprint_nr</li>
                           <li>reflection</li>
                           <li>feedback</li>
                           <li>
                              status
                              <ul class="list-disc">
                                 <li>id</li>
                                 <li>name</li>
                              </ul>
                           </li>
                           <li>
                              goals
                              <ul class="list-disc">
                                 <li>id</li>
                                 <li>description</li>
                                 <li>is_retrospective</li>
                                 <li>created_at</li>
                                 <li>
                                    workprocesses
                                    <ul class="list-disc">
                                       <li>id</li>
                                       <li>sprint_goal_id</li>
                                       <li>workprocess_id</li>
                                    </ul>
                                    ...
                                 </li>
                              </ul>
                              ...
                           </li>
                           <li>created_at</li>
                        </ul>
                     </li>
                  </ul>            
               </div>
            </div>
         </div>
         <div class="endpoint mb-ch-10">
            <div>
               <h2><span class="font-bold">POST</span> | <span class="italic">/sprints</span></h2>
               <p>De nieuwe sprint opslaan.</p>
            </div>
            <h4>Parameters:</h4>
            <ul class="list-disc">
                <li><code>api_key (str)</code> - API-gebruikerssleutel *REQUIRED</li>
                <li><code>project_id (int)</code> - Project id *REQUIRED</li>
                <li><code>date_start (date)</code> - Startdatum *REQUIRED</li>
                <li>
                  <code>goals (array)</code>
                     <ul class="list-disc">
                        <li><code>description (str)</code> - Beschrijving van het doel *REQUIRED</li>
                        <li><code>is_retrospective (bool)</code> - Is het een retrospectief *REQUIRED</li>
                        <li>
                           <code>workprocesses_ids (array)</code> - Ids van werkprocesses
                           <br/>...
                        </li>
                     </ul>
                     ...
                </li>
            </ul>
            <h4>Returns:</h4>
            <div x-data="{ open: false }" class="mb-4">
               <button @click="open = !open" class="bg-blue-600 text-white px-4 py-2 rounded-md">
                  JSON-structuur weergeven
               </button>
               <div x-show="open" class="mt-4 bg-gray-100 p-4 rounded-md">
                  <ul class="list-disc">
                     <li>status</li>
                     <li>message</li>
                     <li>
                        data
                        <ul class="list-disc">
                           <li>id</li>
                           <li>project_id</li>
                           <li>sprint_nr</li>
                           <li>reflection</li>
                           <li>feedback</li>
                           <li>
                              status
                              <ul class="list-disc">
                                 <li>id</li>
                                 <li>name</li>
                              </ul>
                           </li>
                           <li>
                              goals
                              <ul class="list-disc">
                                 <li>id</li>
                                 <li>description</li>
                                 <li>is_retrospective</li>
                                 <li>created_at</li>
                                 <li>
                                    workprocesses
                                    <ul class="list-disc">
                                       <li>id</li>
                                       <li>sprint_goal_id</li>
                                       <li>workprocess_id</li>
                                    </ul>
                                    ...
                                 </li>
                              </ul>
                              ...
                           </li>
                           <li>created_at</li>
                        </ul>
                     </li>
                  </ul>            
               </div>
            </div>
         </div>
         <div class="endpoint mb-ch-10">
            <div>
               <h2><span class="font-bold">DELETE</span> | <span class="italic">/sprints/{sprint_id}</span></h2>
               <p>Sprint verwijderen.</p>
            </div>
            <h4>Parameters:</h4>
            <ul class="list-disc">
                <li><code>api_key (str)</code> - API-gebruikerssleutel *REQUIRED</li>
            </ul>
            <h4>Returns:</h4>
            <div x-data="{ open: false }" class="mb-4">
               <button @click="open = !open" class="bg-blue-600 text-white px-4 py-2 rounded-md">
                  JSON-structuur weergeven
               </button>
               <div x-show="open" class="mt-4 bg-gray-100 p-4 rounded-md">
                  <ul class="list-disc">
                     <li>status</li>
                     <li>message</li>
                  </ul>      
               </div>
            </div>
         </div>
      </div>
   </div>
   
</div>
<script src="//unpkg.com/alpinejs" defer></script>