import { Component } from '@angular/core';
import { FormControl, FormGroup, ReactiveFormsModule } from '@angular/forms'
import { HttpClient } from '@angular/common/http';
import { RouterLink } from '@angular/router';
import { RouterOutlet } from '@angular/router';
import {Router} from '@angular/router';
import { from } from 'rxjs';
import { error } from 'console';
import { Token } from '@angular/compiler';

@Component({
  selector: 'app-formulario',
  standalone: true,
  imports: [RouterOutlet,ReactiveFormsModule,RouterLink],
  templateUrl: './formulario.component.html',
  styleUrl: './formulario.component.css'
})
export class FormularioComponent {
  form:FormGroup;
      constructor(private http: HttpClient, private router: Router) {
      this.form = new FormGroup({
      idEmpleado: new FormControl(''),
      nombreEmpleado: new FormControl(''),
      correoEmpleado: new FormControl(''),
      passwordEmpleado: new FormControl('')

    });
  }

  onSubmit(){
    if (this.form.valid) {
      const datos = this.form.value;
      this.http.post('http://localhost:8000/api/empleado', datos)
      .subscribe({
        next: (respuesta) => {
          console.log('Datos enviados exitosamente', respuesta);
          this.router.navigate(['/formulario']);

        },
        error: (error) => {
          console.log ('Error al enviar datos', error);

        }
      });
    } else {
      console.log('Formulario invalido');
    }
  }

}
