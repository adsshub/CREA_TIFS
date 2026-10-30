<!-- Formulaire des projets : utilisé pour l'AJOUT et la MODIFICATION (même vue, donc ré-utilisée)
     Variables : $formTitle, $formAction, $project, $projectTagIds, $creatifs, $tags -->
<div class="col-lg-8 py-3">
          <!--
            /projects/add/form.html          (ajout — champs vides)
            /projects/id/slug/edit/form.html  (modification — champs pré-remplis par le contrôleur)
          -->
          
      <h1 class="mb-4"><?php echo $formTitle; ?></h1>

      <form
          action="<?php echo $formAction; ?>"
          method="post"
          enctype="multipart/form-data"
          class="ct-form-card"
      >
          <label for="title">Titre du projet</label>
          <input
              type="text"
              name="title"
              id="title"
              class="form-control"
              maxlength="45"
              required
              value="<?php echo $project['titre']; ?>"
              placeholder="Ex : Frange Kamikaze"
          />

          <label for="resume">Résumé</label>
          <textarea
              id="resume"
              name="resume"
              class="form-control"
              rows="2"
              maxlength="255"
              placeholder="Une phrase d'accroche, affichée (tronquée) sur la page d'accueil..."
          ><?php echo $project['resume']; ?></textarea>

          <label for="text">Description</label>
          <textarea
              id="text"
              name="text"
              class="form-control"
              rows="5"
              placeholder="Racontez l'histoire (courageuse) de ce projet..."
          ><?php echo $project['texte']; ?></textarea>

          <label for="creatif-file">Photo du résultat</label>
          <div class="ct-dropzone">
              ✂️ Glissez une image ou choisissez-la ci-dessous
              <input
                  type="file"
                  class="form-control-file"
                  id="creatif-file"
                  name="image"
                  accept="image/*"
              />
          </div>

          <label for="category">Créa'tif</label>
          <select
              id="category"
              name="category_id"
              class="form-control"
              required
          >
              <option
                  value=""
                  disabled
                  <?php
                      if ($project['creatif'] == 0) {
                          echo 'selected';
                      }
                  ?>
              >
                  Sélectionnez le créa'tif
              </option>

              <?php foreach ($creatifs as $creatif) : ?>
                  <option
                      value="<?php echo $creatif['id']; ?>"
                      <?php
                          if ($project['creatif'] == $creatif['id']) {
                              echo 'selected';
                          }
                      ?>
                  >
                      <?php echo $creatif['pseudo']; ?>
                  </option>
              <?php endforeach; ?>
          </select>

          <label>
              Tags
              <span style="font-weight: 400; font-size: 0.8rem; color: #4a3a5a">
                  (facultatif)
              </span>
          </label>

          <div class="ct-tag-choice">
              <?php foreach ($tags as $tag) : ?>
                  <label>
                      <input
                          type="checkbox"
                          name="tags[]"
                          value="<?php echo $tag['id']; ?>"
                          <?php
                              if (in_array((int) $tag['id'], $projectTagIds, true)) {
                                  echo 'checked';
                              }
                          ?>
                      />
                      <?php echo $tag['nom']; ?>
                  </label>
              <?php endforeach; ?>
          </div>

          <div>
              <input
                  class="ct-btn ct-btn--primary"
                  type="submit"
                  value="Enregistrer"
              />

              <input
                  class="ct-btn ct-btn--ghost"
                  type="reset"
                  value="Réinitialiser"
              />
          </div>
      </form>

        </div>