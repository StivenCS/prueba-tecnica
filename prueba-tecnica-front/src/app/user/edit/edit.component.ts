import { Component, OnInit } from '@angular/core';

import { UserService } from '../user.service';
import { ActivatedRoute, Router } from '@angular/router';
import { FormGroup, FormControl, Validators} from '@angular/forms';
import { User } from '../user';
import { MatSnackBar } from '@angular/material/snack-bar';

@Component({
  selector: 'app-edit',
  templateUrl: './edit.component.html',
  styleUrls: ['./edit.component.css']
})
export class EditComponent implements OnInit {
  forma: FormGroup = new FormGroup('');
  id: number = 0;
  user: any;
  data: any;
  countries: any;

  constructor(
    public userService: UserService,
    private route: ActivatedRoute,
    private snackbar: MatSnackBar,
    private router: Router
  ) { }

  ngOnInit(): void {

    this.id = this.route.snapshot.params['user.id'];

    this.userService.find(this.id).subscribe((data: User)=>{
      this.user = data;
    });

    this.userService.getCategories().subscribe(res => {
      this.data = res;
    });

    this.userService.getCountries().subscribe(res => {
      this.countries = res;
    });

    this.forma = new FormGroup({
      nombre: new FormControl('', [ Validators.required, Validators.pattern('^[a-zA-ZÁáÀàÉéÈèÍíÌìÓóÒòÚúÙùÑñüÜ \-\']+'), Validators.minLength(5), Validators.maxLength(100)]),
      apellido:  new FormControl('', [ Validators.required, Validators.pattern('^[a-zA-ZÁáÀàÉéÈèÍíÌìÓóÒòÚúÙùÑñüÜ \-\']+'), Validators.maxLength(100)]),
      cedula: new FormControl('', [ Validators.required, Validators.pattern("^[0-9]*$"), Validators.max(9999999999)]),
      correo: new FormControl('', [ Validators.required, Validators.email, Validators.maxLength(150) ]),
      pais: new FormControl('', [ Validators.required]),
      direccion: new FormControl('', [ Validators.required, Validators.maxLength(180)]),
      telefono: new FormControl('', [ Validators.required, Validators.pattern("^[0-9]*$"), Validators.maxLength(10)]),
      categoria: new FormControl('', [ Validators.required]),
    });
  }

  get f(){
    return this.forma.controls;
  }

  submit(){
    console.log(this.forma.value);
    this.userService.update(this.id, this.forma.value).subscribe(res => {
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
    })
  }

}

