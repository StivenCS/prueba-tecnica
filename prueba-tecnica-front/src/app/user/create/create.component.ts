import { Component } from '@angular/core';
import { UserService } from '../user.service';
import { Router } from '@angular/router';
import { RouterModule } from '@angular/router';
import { FormGroup, FormControl, Validators } from '@angular/forms';
import { MatSnackBar } from '@angular/material/snack-bar';

@Component({
  selector: 'app-create',
  templateUrl: './create.component.html',
  styleUrls: ['./create.component.css']
})

export class CreateComponent {

  form: FormGroup = new FormGroup('');
  data: any;
  countries: any;
  message: any;

  constructor(
    public userService: UserService,
    private snackbar: MatSnackBar,
    private router: Router
  ) { }

  ngOnInit(): void {
    this.userService.getCategories().subscribe(res => {
      this.data = res;
    });

    this.userService.getCountries().subscribe(res => {
      this.countries = res;
    });

    this.form = new FormGroup({
      nombre: new FormControl('', [Validators.required, Validators.pattern('^[a-zA-ZÁáÀàÉéÈèÍíÌìÓóÒòÚúÙùÑñüÜ \-\']+'), Validators.minLength(5), Validators.maxLength(100)]),
      apellido: new FormControl('', [Validators.required, Validators.pattern('^[a-zA-ZÁáÀàÉéÈèÍíÌìÓóÒòÚúÙùÑñüÜ \-\']+'), Validators.maxLength(100)]),
      cedula: new FormControl('', [Validators.required, Validators.pattern("^[0-9]*$"), Validators.max(9999999999)]),
      correo: new FormControl('', [Validators.required, Validators.email, Validators.maxLength(150)]),
      pais: new FormControl('', [Validators.required]),
      direccion: new FormControl('', [Validators.required, Validators.maxLength(180)]),
      telefono: new FormControl('', [Validators.required, Validators.pattern("^[0-9]*$"), Validators.maxLength(10)]),
      categoria: new FormControl('', [Validators.required]),
    });
  }

  get f() {
    return this.form.controls;
  }

  submit() {
    this.userService.create(this.form.value).subscribe(res => {
      if (res.status == 201) {
        this.snackbar.open(res.message, '', {
          duration: 5000
        });
        this.router.navigateByUrl('user/index');
      }
      if (res.status == 400) {
        console.log(res);
        let dat: string = '';
        for (let k in res.message ) {
          console.log(res.message[k][0]);
          dat+= `${res.message[k][0]}` ;
        }
        this.snackbar.open(dat.toString(), 'OK', {
          duration: 5000,
          verticalPosition: 'top'
        });
      }
    }
    )
  }
}
